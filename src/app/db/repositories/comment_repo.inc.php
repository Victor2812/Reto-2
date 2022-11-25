<?php


abstract class CommentRepository {

    /**
     * Crea un nuevo comentario
     * @param string $text Texto del comentario
     * @param UserEntity $author Autor del comentario
     * @param PostEntity|null $post Post al que comentar (puede ser nulo)
     * @param CommentEntity|null $comment Comentario padre (puede ser nulo)
     */
    public static function createNewComment(string $text, UserEntity $author,
        PostEntity|null $post, CommentEntity|null $comment, FileEntity|null $file = null): CommentEntity|null {
        
            global $db;

            // el unico tipo en común es null, por lo tanto
            // se comprueba que los dos sean nulos
            // además, se comprueba que los dos tengan datos (no sean nulos)
            if ($post == $comment || (!$post && !$comment) ) {
                throw new Exception("Es necesario especificar un post o un comentario", 1);
            }

            $sql = 'INSERT INTO comments (text, author, post, comment, file) VALUES (:t, :a, :p, :c, :f)';

            $statement = $db->prepare($sql);
            $statement->execute([
                ':t' => $text,
                ':a' => $author->getId(),
                ':p' => $post ? $post->getId() : null,
                ':c' => $comment ? $comment->getId() : null,
                ':f' => $file ? $file->getId() : null
            ]);

            if (($commentId = $db->lastInsertId())) {
                // Añadir puntos 
                $author->addPoints(POINTS_COMMENT);
                UserRepository::update($author);

                return self::getCommentById($commentId);
            }

            return null;
    }

    /**
     * Convierte un array de datos a un CommentEntity
     * @param array $data Datos
     * @param PostEntity|null $postParent Post padre
     * @param CommentEntity|null $commentParent Comentario padre
     * @return CommentEntity|null
     */
    private static function getCommentFromData(array $data, PostEntity|null $postParent = null, CommentEntity|null $commentParent = null): CommentEntity|null {
        if ($author = UserRepository::getUserById(intval($data['author']))) {
            // Obtener el post
            $post = $data['post'];
            // se comprueba que el post padre está definido para evitar pedir a la BBDD unos datos que ya sabemos
            if ($postParent && $postParent->getId() == $post) {
                $post = $postParent;
            } else if ($post) {
                $post = PostRepository::getPostById(intval($post));
            }

            // Obtener el comentario padre
            $comment = $data['comment'];
            // se comprueba que el comentario padre está definido para evitar pedir a la BBDD unos datos que ya sabemos
            if ($commentParent && $commentParent->getId() == $comment) {
                $comment = $commentParent;
            }
            // comprobar que el comentario padre no es el mismo comentario
            // para evitar un bucle infinito de llamadas a la misma función
            else if ($comment && $comment != $data['id']) {
                $comment = self::getCommentById(intval($comment));
            }

            // Obtener el archivp
            $file = $data['file'];
            if ($file) {
                $file = FileRepository::getFileById(intval($file));
            }

            return new CommentEntity(
                intval($data['id']),
                $data['text'],
                $author,
                $post,
                $comment,
                strtotime($data['creation_date']),
                $file,
            );
        }

        return null;
    }

    /**
     * Obtener el comentario por su ID
     * @param int $id
     */
    public static function getCommentById(int $id): CommentEntity|null {
        global $db;

        $sql = 'SELECT * FROM comments WHERE id = :id';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':id' => $id
        ]);

        if ($data = $statement->fetch()) {
            return self::getCommentFromData($data);
        }

        return null;
    }

    /**
     * Obtiene el numero de votos de un comentario
     * @param CommentEntity $comment Comentario
     * @return int Cantidad de votos
     */
    public static function getCommentVotes(CommentEntity $comment): int {
        global $db;

        $sql = "SELECT count(comment) FROM votes WHERE comment = :c";

        $statement = $db->prepare($sql);
        $statement->execute([
            ':c' => $comment->getId()
        ]);

        if ($data = $statement->fetch()) {
            return $data[0];
        }

        return 0;
    }

    /**
     * Añade un voto al comentario
     * @param CommentEntity $comment Comentario
     * @param UserEntity $user Autor del voto
     * @return bool Se ha añadido o no
     */
    public static function addCommentVote(CommentEntity $comment, UserEntity $user): bool {
        global $db;

        // Esta sentencia actualiza el bookmark, y si ya existe, no hace nada
        $sql = 'INSERT INTO votes (user, comment) VALUES (:u, :c) ON DUPLICATE KEY UPDATE comment=:c';

        $statement = $db->prepare($sql);

        // devuelve si la sentencia se ha ejecutado correctamente
        return $statement->execute([
            ':u' =>          $user->getId(),
            ':c' =>          $comment->getId()
        ]);
    }

    /**
     * Elimina un voto del comentario
     * @param CommentEntity $comment Comentario
     * @param UserEntity $user Autor del voto
     * @return bool Se ha quitado o no
     */
    public static function removeCommentVote(CommentEntity $comment, UserEntity $user): bool {
        global $db;

        // Esta sentencia actualiza el bookmark, y si ya existe, no hace nada
        $sql = 'DELETE FROM votes WHERE user = :u AND comment = :c';

        $statement = $db->prepare($sql);

        // devuelve si la sentencia se ha ejecutado correctamente
        return $statement->execute([
            ':u' =>          $user->getId(),
            ':c' =>          $comment->getId()
        ]);
    }

    /**
     * Comrueba si un usuario ha votado el comentario
     * @param CommentEntity $comment Comentario
     * @param UserEntity $user Autor del voto
     * @return bool Votado o no
     */
    public static function isCommentVoted(CommentEntity $comment, UserEntity $user): bool {
        global $db;

        // Esta sentencia actualiza el bookmark, y si ya existe, no hace nada
        $sql = 'SELECT user FROM votes WHERE user = :u AND comment = :c';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':u' =>          $user->getId(),
            ':c' =>          $comment->getId()
        ]);

        return $statement->fetch() != null;
    }

    /**
     * Obtiene la lista de comentarios de un post de forma paginada
     * @param PostEntity $post El Post
     * @param int $offset A partir de qué post índice se quiere cargar
     * @param int $limit Cuántos comentarios se quieren cargar
     * @return array Lista de comentarios
     */
    public static function getPostComments(PostEntity $post, int $offset = 0, int $limit = 15): array {
        global $db;

        $comments = [];

        $sql = "SELECT * FROM comments WHERE post = :p ORDER BY creation_date DESC LIMIT $offset, $limit";

        $statement = $db->prepare($sql);
        $statement->execute([
            ':p' => $post->getId()
        ]);

        while ($data = $statement->fetch()) {
            $comments[] = self::getCommentFromData($data, $post, null);
        }

        return $comments;
    }

    /**
     * Obtiene la cantidad de comentarios de un post
     * @param PostEntity $post El Post
     * @return int Cantidad de comentarios
     */
    public static function getPostCommentNum(PostEntity $post): int {
        global $db;

        $sql = "SELECT count(id) FROM comments WHERE post = :p";

        $statement = $db->prepare($sql);
        $statement->execute([
            ':p' => $post->getId()
        ]);

        if ($data = $statement->fetch()) {
            return $data[0];
        }

        return 0;
    }

    /**
     * Obtiene los subcomentarios de los comentarios
     * @param CommentEntity $comment Comentario padre
     * @param int $offset A partir de qué post índice se quiere cargar
     * @param int $limit Cuántos comentarios se quieren cargar
     * @return array Lista de comentarios
     */
    public static function getCommentSubcomments(CommentEntity $comment, int $offset = 0, int $limit = 15): array {
        global $db;

        $comments = [];

        $sql = "SELECT * FROM comments WHERE comment = :c LIMIT $offset, $limit";

        $statement = $db->prepare($sql);
        $statement->execute([
            ':c' => $comment->getId()
        ]);

        while ($data = $statement->fetch()) {
            $comments[] = self::getCommentFromData($data, null, $comment);
        }

        return $comments;
    }

    /**
     * Obtiene la cantidad de subcomentarios de un comentario
     * @param CommentEntity $comment El comentario
     * @return int Cantidad de subcomentarios
     */
    public static function getCommentSubcommentNum(CommentEntity $comment): int {
        global $db;

        $sql = "SELECT count(id) FROM comments WHERE comment = :c";

        $statement = $db->prepare($sql);
        $statement->execute([
            ':c' => $comment->getId()
        ]);

        if ($data = $statement->fetch()) {
            return $data[0];
        }

        return 0;
    }
}