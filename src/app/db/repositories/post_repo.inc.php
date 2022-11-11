<?php


abstract class PostRepository {
    public static function createNewPost(string $title, string $text, CategoryEntity $category, UserEntity $author, array $tags): PostEntity|null {
        global $db;

        $sql = "INSERT INTO posts (title, text, category, author) VALUES (:title, :text, :category, :author)";
        $statement = $db->prepare($sql);
        $statement->execute([
            ':title' => $title,
            ':text' => $text,
            ':category' => $category->getId(),
            ':author' => $author->getId()
        ]);

        if (($newPostId = $db->lastInsertId())) {
            foreach ($tags as $tag) {
                $s = $db->prepare("INSERT INTO tagged (tag, post) VALUES (:tag, :post)");
                $s->execute([
                    ':tag' => $tag->getId(),
                    ':post' => $newPostId
                ]);
            }
            
            return self::getPostById($newPostId);
        }

        return null;
    }

    private static function getPostFromData(array $data): PostEntity|null {
        $categ = CategoryRepository::getCategoryById(intval($data['category']));
        $author = UserRepository::getUserById(intval($data['author']));
        $tags = TagRepository::getTagsByPostId(intval($data['id']));

        if ($categ && $author) {
            return new PostEntity(
                intval($data['id']),
                $data['title'],
                $data['text'],
                $categ,
                strtotime($data['creation_date']),
                $author,
                $tags
            );
        }
    }

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

    public static function getPostsByAuthor(UserEntity $author): array {
        global $db;

        $posts = [];

        $sql = 'SELECT * FROM posts WHERE author = :author';

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

        return null;
    }

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

    // actualizar
}