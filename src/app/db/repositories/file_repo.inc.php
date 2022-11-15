<?php


abstract class FileRepository {
    /**
     * Crea una nueva referencia de un archivo en la base de datos
     * @param string $name Nombre del archivo
     * @param string $path Ruta del archivo
     * @param CommentEntity $comment Comentario asocidado
     * @return FileEntity|null Referencia
     */
    public static function createNewFile(string $name, string $path, CommentEntity $comment): FileEntity|null {
        global $db;

        $sql = 'INSERT INTO files (name, path, comment) VALUES (:n, :p, :c)';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':n' => $name,
            ':p' => $path,
            ':c' => $comment->getId()
        ]);

        if (($fileId = $db->lastInsertId())) {
            return new FileEntity(
                $fileId,
                $name,
                $path,
                $comment
            );
        }

        return null;
    }

    public static function getCommentFiles(CommentEntity $comment): array {
        global $db;

        $files = [];

        $sql = 'SELECT * FROM files WHERE comment = :c';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':c' => $comment->getId()
        ]);

        while (($data = $statement->fetch())) {
            $files[] = new FileEntity(
                $data['id'],
                $data['name'],
                $data['path'],
                $comment
            );
        }

        return $files;
    }
}