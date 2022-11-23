<?php


abstract class PostRepository {
    /**
     * Crea un nuevo post
     * @param string $title Título del post
     * @param string $text Texto del post
     * @param CategoryEntity $category Categoría del post
     * @param UserEntity $author Autor del post
     * @param array $tags Tags del post
     * @return PostEntity|null
     */
    public static function createNewPost(string $title, string $text, CategoryEntity $category,
        UserEntity $author, array $tags, FileEntity|null $file): PostEntity|null {

        global $db;

        $sql = "INSERT INTO posts (title, text, category, author, file) VALUES (:title, :text, :category, :author, :file)";
        $statement = $db->prepare($sql);
        $statement->execute([
            ':title' => $title,
            ':text' => $text,
            ':category' => $category->getId(),
            ':author' => $author->getId(),
            ':file' => $file ? $file->getId() : null,
        ]);

        if (($newPostId = $db->lastInsertId())) {
            foreach ($tags as $tag) {
                $s = $db->prepare("INSERT INTO tagged (tag, post) VALUES (:tag, :post)");
                $result = $s->execute([
                    ':tag' => $tag->getId(),
                    ':post' => $newPostId
                ]);

                // sumar 1 al uso de cada TAG
                if ($result) {
                    $tag->addCounter(1);
                    TagRepository::update($tag);
                }
            }

            // Añadir puntos 
            $author->addPoints(POINTS_POST);
            UserRepository::update($author);

            return self::getPostById($newPostId);
        }
        return null;
    }

    /**
     * Obtiene el objeto PostEntity a raíz de una fila obtenida de la sentencia SQL
     */
    private static function getPostFromData(array $data): PostEntity|null {
        $categ = CategoryRepository::getCategoryById(intval($data['category']));
        $author = UserRepository::getUserById(intval($data['author']));
        $tags = TagRepository::getTagsByPostId(intval($data['id']));
        $file = $data['file']
            ? $file = FileRepository::getFileById(intval($data['file']))
            : null;

        if ($categ && $author) {
            return new PostEntity(
                intval($data['id']),
                $data['title'],
                $data['text'],
                $categ,
                strtotime($data['creation_date']),
                $author,
                $tags,
                $file
            );
        }

        return null;
    }

    /**
     * Obtiene un post por su ID
     * @param int $id ID del post
     * @return PostEntity|null
     */
    public static function getPostById(int $id): PostEntity|null {
        global $db;

        $sql = 'SELECT * FROM posts WHERE id = :id';

        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([
            ':id' => $id
        ]);

        if (($data = $statement->fetch())) {
            return self::getPostFromData($data);
        }

        return null;
    }

    /**
     * Obtiene un post por su ID
     * @param int $id ID del post
     * @param int $offset A partir de qué post índice se quiere cargar
     * @param int $limit Cuántos posts se quieren cargar
     * @return PostEntity|null
     */
    public static function getPostsByAuthor(UserEntity $author, int $offset, int $limit = 15): array {
        global $db;

        $posts = [];

        $sql = "SELECT * FROM posts WHERE author = :author ORDER BY creation_date DESC LIMIT $offset, $limit;";

        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([
            ':author' => $author->getId()
        ]);

        while (($data = $statement->fetch())) {
            if ($p = self::getPostFromData($data)) {
                $posts[] = $p;
            }
        }

        return $posts;
    }

    /**
     * Obtener los posts paginados y ordenados por su fecha de creación
     * @param int $offset A partir de qué post índice se quiere cargar
     * @param int $limit Cuántos posts se quieren cargar
     * @return array Array de posts
     */
    public static function getLastPosts(int $offset = 0, int $limit = 15): array {
        global $db;

        $sql = "SELECT * FROM posts ORDER BY creation_date DESC LIMIT $offset, $limit;";

        $posts = [];

        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();

        while (($data = $statement->fetch())) {
            if ($p = self::getPostFromData($data)) {
                $posts[] = $p;
            }
        }

        return $posts;
    }

    /**
     * Actualiza el post a la base de datos
     * @param PostEntity $post Post a actulizar
     */
    public static function update(PostEntity $post) {
        global $db;

        $sql = 'UPDATE posts SET title=:title, text=:text, category=:categ, author=:author WHERE id = :id';
    
        $statement = $db->prepare($sql);
        $statement->execute([
            ':title' =>     $post->getTitle(),
            ':text' =>      $post->getText(),
            ':categ' =>     $post->getCategory()->getId(),
            ':author' =>    $post->getAuthor()->getId(),
            ':id' =>         $post->getId()
        ]);

        // Borrar todos los tags del post y aplicarlos de nuevo para actualizarlos
        $db->prepare('DELETE FROM tagged WHERE post = :id')->execute([':id', $post->getId()]);
        // Crear los enlaces a los tags
        foreach ($post->getTags() as $tag) {
            $s = $db->prepare("INSERT INTO tagged (tag, post) VALUES (:tag, :post)");
            $s->execute([
                ':tag' => $tag->getId(),
                ':post' => $post->getId()
            ]);
        }
    }

    public static function getUserBookmarkedPosts(UserEntity $user): array {
        global $db;

        $posts = [];

        $sql = 'SELECT p.* FROM posts p, bookmarks b WHERE b.user = :user AND p.id = b.post';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':user' =>         $user->getId()
        ]);

        $statement->setFetchMode(PDO::FETCH_ASSOC);
        while (($data = $statement->fetch())) {
            if ($post = self::getPostFromData($data)) {
                $posts[] = $post;
            }
        }

        return $posts;
    }

    public static function getPostBookmarkCount(PostEntity $post): int {
        global $db;

        $sql = 'SELECT count(post) FROM bookmarks b WHERE b.post = :p';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':p' =>            $post->getId(),
        ]);

        if ($data = $statement->fetch()) {
            return $data[0];
        }

        return 0;
    }

    public static function addPostToUserBookmark(PostEntity $post, UserEntity $user) {
        global $db;

        // Esta sentencia actualiza el bookmark, y si ya existe, no hace nada
        $sql = 'INSERT INTO bookmarks (user, post) VALUES (:user, :post) ON DUPLICATE KEY UPDATE post=:post';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':user' =>          $user->getId(),
            ':post' =>          $post->getId()
        ]);
    }

    public static function removeBookmarkedPost(PostEntity $post, UserEntity $user) {
        global $db;

        $sql = 'DELETE FROM bookmarks WHERE user=:user AND post=:post';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':user' =>          $user->getId(),
            ':post' =>          $post->getId()
        ]);
    }

    public static function isPostBookmarked(UserEntity $user, PostEntity $post): bool {
        global $db;

        $posts = [];

        $sql = 'SELECT post FROM bookmarks b WHERE b.user = :user AND b.post = :p LIMIT 1';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':user' =>         $user->getId(),
            ':p' =>            $post->getId(),
        ]);

        return $statement->fetch() != null;
    }
}