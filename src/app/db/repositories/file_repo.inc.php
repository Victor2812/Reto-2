<?php


abstract class FileRepository {
    /**
     * Crea una nueva referencia de un archivo en la base de datos
     * @param string $name Nombre del archivo
     * @param string $path Ruta del archivo
     * @return FileEntity|null Referencia
     */
    public static function createNewFile(string $name, string $path): FileEntity|null {
        global $db;

        $sql = 'INSERT INTO files (name, path) VALUES (:n, :p)';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':n' => $name,
            ':p' => $path
        ]);

        if (($fileId = $db->lastInsertId())) {
            return new FileEntity(
                $fileId,
                $name,
                $path
            );
        }

        return null;
    }

    public static function getFileById(int $id) {
        global $db;

        $sql = 'SELECT * FROM files WHERE id = :i';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':i' => $id
        ]);

        if ($data = $statement->fetch()) {
            return new FileEntity(
                $data['id'],
                $data['name'],
                $data['path']
            );
        }

        return null;
    }
}