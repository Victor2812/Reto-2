<?php


abstract class CategoryRepo {
    /**
     * Obtener una categoría por su Id
     * @param int $id Id de la categoría
     * @return CategoryEntity|null
     */
    public static function getCategoryById(int $id): CategoryEntity|null {
        global $db;

        $sql = 'SELECT * FROM categories WHERE id = :id';

        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([
            ':id' => $id
        ]);

        if (($data = $statement->fetch())) {
            return new CategoryEntity(
                intval($data['id']),
                $data['name']
            );
        }
        return null;
    }

    /**
     * Obtener todas las categorias
     * @return array
     */
    public static function getAllCategories(): array {
        global $db;

        $categs = [];

        $sql = 'SELECT * FROM categories';

        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();

        while (($data = $statement->fetch())) {
            $categs[] = new CategoryEntity(
                intval($data['id']),
                $data['name']
            );
        }
        return $categs;
    }
}