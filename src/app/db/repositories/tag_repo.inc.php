<?php


abstract class TagRepository {
    /**
     * Crea un tag nuevo
     * @param string $name Nombre del tag
     */
    public static function createNewTag(string $name): null|TagEntity {
        global $db;

        $name = strtolower($name);

        if (!self::doesTagExist($name)) {
            $sql = 'INSERT INTO tags (name, counter) VALUES (:n, 0)';

            $statement = $db->prepare($sql);
            $statement->execute([
                ':n' => $name
            ]);

            
            if (($newTagId = $db->lastInsertId())) {
                return new TagEntity($newTagId, $name, 0);
            } else {
                print_r('error');
                return null;
            }
        } else {
            return self::getTagByName($name);
        }
    }

    /**
     * Obtiene un tag con su nombre
     * @param string $name Nombre
     */
    public static function getTagByName(string $name): null|TagEntity {
        global $db;

        $sql = 'SELECT * FROM tags WHERE name = :name';

        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([
            ':name' => $name
        ]);

        if (($data = $statement->fetch())) {
            return new TagEntity(
                intval($data['id']),
                $data['name'],
                intval($data['counter'])
            );
        }
        return null;
    }

    /**
     * Comprueba si una etiqueta existe
     * @return bool
     */
    public static function doesTagExist($name):bool {
        return self::getTagByName($name) != null;
    }
}