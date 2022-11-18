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
     * Obtener todos las categorias existentes limitasdas y ordenadas
     * @return array
     */
    public static function getAllTags(int $limit = 10): array{
        global $db;

        $tags = [];
        $sql = "SELECT * FROM tags ORDER BY counter DESC LIMIT $limit";

        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();

        while ($data = $statement->fetch()) {
            $tags[] = new TagEntity(
                intval($data['id']),
                $data['name'],
                intval($data['counter'])
            );
        }

        return $tags;
    }

    public static function getTagsByPostId(int $postId): array {
        global $db;

        $tags = [];

        $sql = 'SELECT t.* FROM tags t, tagged g WHERE t.id = g.tag AND g.post = :post';
        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([
            ':post' => $postId
        ]);

        while (($data = $statement->fetch())) {
            $tags[] = new TagEntity(
                intval($data['id']),
                $data['name'],
                intval($data['counter'])
            );
        }
        
        return $tags;
    }

    public static function update(TagEntity $tag) {
        global $db;

        $sql = 'UPDATE tags SET name=:name, counter=:counter WHERE id = :id';
    
        $statement = $db->prepare($sql);
        $statement->execute([
            'name' =>       $tag->getName(),
            'counter' =>    $tag->getCounter(),
            'id' =>         $tag->getId()
        ]);
    }

    /**
     * Comprueba si una etiqueta existe
     * @return bool
     */
    public static function doesTagExist($name):bool {
        return self::getTagByName($name) != null;
    }
}