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
        PostEntity|null $post, CommentEntity|null $comment): CommentEntity|null {
        
            global $db;

            // el unico tipo en común es null, por lo tanto
            // se comprueba que los dos sean nulos
            // además, se comprueba que los dos tengan datos (no sean nulos)
            if ($post == $comment || (!$post && !$comment) ) {
                throw new Exception("Es necesario especificar un post o un comentario", 1);
            }

            $sql = 'INSERT INTO comments (text, author, post, comment) VALUES (:t, :a, :p, :c)';

            $statement = $db->prepare($sql);
            $statement->execute([
                ':t' => $text,
                ':a' => $author->getId(),
                ':p' => $post ? $post->getId() : null,
                ':c' => $comment ? $comment->getId() : null
            ]);

            if (($commentId = $db->lastInsertId())) {
                return self::getCommentById($commentId);
            }

            return null;
    }

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

            return new CommentEntity(
                intval($data['id']),
                $data['text'],
                $author,
                $post,
                $comment,
                strtotime($data['creation_date'])
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
     * Obtiene la lista de comentarios de un post de forma paginada
     * @param PostEntity $post El Post
     * @param int $offset A partir de qué post índice se quiere cargar
     * @param int $limit Cuántos comentarios se quieren cargar
     * @return array Lista de comentarios
     */
    public static function getPostComments(PostEntity $post, int $offset = 0, int $limit = 15): array {
        global $db;

        $comments = [];

        $sql = "SELECT * FROM comments WHERE post = :p LIMIT $offset, $limit";

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