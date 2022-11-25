<?php

abstract class UserRepository {
    /**
     * Crea un nuevo usuario
     * @param string $username Nombre del usuario
     * @param string $name Nombre propio del usuario
     * @param string|null $surname Apellido del usuario
     * @param string|null $job Puesto de trabajo
     * @param string $passwd Contraseña del usuario
     * @return UserEntity|null
     */
    public static function createNewUser(string $username, string $name, string|null $surname, string|null $job, string $passwd): UserEntity|null {
        global $db;

        $sql = "INSERT INTO users (username, name, surname, job, passwd) VALUES (:uname, :name, :surname, :job, :passwd)";
        $statement = $db->prepare($sql);

        try {
            $statement->execute([
                ':uname' => $username,
                ':name' => $name,
                ':surname' => $surname,
                ':job' => $job,
                ':passwd' => $passwd
            ]);
        } catch (Exception $ex) {
            return null;
        }

        if (($newUserId = $db->lastInsertId())) {
            return self::getUserById($newUserId);
        }

        return null;
    }

    /**
     * Obtiene el Usuario desde un array de datos
     * @param array $data Datos
     * @return UserEntity
     */
    private static function parseUserFromData(array $data) : UserEntity {
        return new UserEntity(
            $data['id'],
            $data['username'],
            $data['name'],
            $data['surname'],
            $data['image'],
            strtotime($data['date']),
            $data['points'],
            $data['job'],
            $data['passwd']
        );
    }

    /**
     * Obtiene un usuario por su ID
     * @param int $id ID del usuario
     */
    public static function getUserById(int $id): UserEntity|null {
        global $db;

        $sql = 'SELECT * FROM users WHERE id = :id';

        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([
            ':id' => $id
        ]);

        if (($data = $statement->fetch())) {
            return self::parseUserFromData($data);
        }

        return null;
    }

    /**
     * Obtiene un usuario por su nombre
     * @param string $name Nombre del usuario
     */
    public static function getUserByUsername(string $username): UserEntity|null {
        global $db;

        $sql = 'SELECT * FROM users WHERE username = :name';

        $statement = $db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([
            ':name' => $username
        ]);

        if (($data = $statement->fetch())) {
            return self::parseUserFromData($data);
        }

        return null;
    }

    /**
     * Actualiza un usuario
     * @param UserEntity $user
     */
    public static function update(UserEntity $user) {
        global $db;

        $sql = 'UPDATE users SET name=:name, surname=:surname, image=:image, date=:date, points=:points, job=:job, passwd=:passwd WHERE id = :id';
    
        $statement = $db->prepare($sql);
        $statement->execute([
            'name' =>       $user->getName(),
            'surname' =>    $user->getSurname(),
            'image' =>      $user->getImagePath(),
            'date' =>       $user->getCreationDate()->format('Y-m-d'),
            'points' =>     $user->getPoints(),
            'job' =>        $user->getJob(),
            'passwd' =>     $user->getPasswd(),
            'id' =>         $user->getId()
        ]);
    }

    /**
     * Obtiene la lista de seguidores de un Usuario limitada
     * @param UserEntity $user Usuario
     * @param int $limit Cantidade de usuarios
     * @return array Lista de usuarios
     */
    public static function getFollowersInfo(UserEntity $user, int $limit = 4): array {
        global $db;

        $sql = "SELECT u.* 
                FROM users u, followers f 
                WHERE u.id = f.source 
                AND f.destination = :id LIMIT $limit";

        $statement = $db->prepare($sql);
        $statement->execute([
            'id' => $user->getId()
        ]);

        $follower = [];

        while (($data = $statement->fetch())) {
            $follower[] = self::parseUserFromData($data);
        }

        return $follower;
    }

    /**
     * Obtiene la lista de seguidos de un Usuario limitada
     * @param UserEntity $user Usuario
     * @param int $limit Cantidade de usuarios
     * @return array Lista de usuarios
     */
    public static function getFollowingInfo(UserEntity $user, int $limit = 4) {
        global $db;

        $sql = "SELECT u.*
        FROM users u, followers f 
        WHERE u.id = f.destination
        AND f.source = :id LIMIT $limit";

        $statement = $db->prepare($sql);
        $statement->execute([
            'id' => $user->getId()
        ]);

        $following = [];

        while (($data = $statement->fetch())) {
            $following[] = self::parseUserFromData($data);
        }

        
        return $following;
    }

    /**
     * Obtiene la cantidad de seguidores de un Usuario
     * @param UserEntity $user Usuario
     * @return int Cantidad
     */
    public static function getFollowersCount(UserEntity $user): int {
        global $db;

        $sql = 'SELECT count(source) FROM followers WHERE destination = :id';

        $statement = $db->prepare($sql);
        $statement->execute([
            'id' => $user->getId()
        ]);

        $data = $statement->fetch();

        return $data ? $data[0] : 0;
    }

    /**
     * Obtiene la cantidad de seguidos de un Usuario
     * @param UserEntity $user Usuario
     * @return int Cantidad
     */
    public static function getFollowingCount(UserEntity $user) {
        global $db;

        $sql = 'SELECT count(destination) FROM followers WHERE source = :id';

        $statement = $db->prepare($sql);
        $statement->execute([
            'id' => $user->getId()
        ]);

        $data = $statement->fetch();

        return $data ? $data[0] : 0;
    }

    /**
     * Comprueba si un usuario está siguiendo a otro
     * @param UserEntity $source Usuario que sigue a
     * @param UserEntity $destination Usuario que es seguido por
     * @return bool Source sigue a Destination
     */
    public static function isUserFollowingUser(UserEntity $source, UserEntity $destination): bool {
        global $db;

        $sql = 'SELECT "a" FROM followers WHERE source = :s AND destination = :d';

        $statement = $db->prepare($sql);
        $statement->execute([
            ':s' => $source->getId(),
            ':d' => $destination->getId(),
        ]);

        $data = $statement->fetch();

        // si $data no es nulo, significa que el usuario sigue al usuario
        return $data != null;
    }

    /**
     * Hacer que un usuario siga a otro
     * @param UserEntity $source Usuario que sigue a
     * @param UserEntity $destination Usuario que es seguido por
     * @return bool Source sigue a Destination
     */
    public static function addUserFollow(UserEntity $source, UserEntity $destination) {
        global $db;

        $sql = 'INSERT INTO followers (source, destination) VALUES (:s, :d) ON DUPLICATE KEY UPDATE source=:s';

        $statement = $db->prepare($sql);
        return $statement->execute([
            ':s' => $source->getId(),
            ':d' => $destination->getId(),
        ]);
    }

    /**
     * Eliminar el seguimiento de un usuario a otro
     * @param UserEntity $source Usuario que sigue a
     * @param UserEntity $destination Usuario que es seguido por
     * @return bool Source sigue a Destination
     */
    public static function removeUserFollow(UserEntity $source, UserEntity $destination): bool {
        global $db;

        $sql = 'DELETE FROM followers where source = :s AND destination = :d';

        $statement = $db->prepare($sql);
        return $statement->execute([
            ':s' => $source->getId(),
            ':d' => $destination->getId(),
        ]);
    }

    /**
     * Obtener los primeros n usuarios del ranking de puntos
     * @param int $limit Cantidad de usuarios
     * @return array Lista de usuarios
     */
    public static function getUserRanking(int $limit = 10): array {
        global $db;

        $sql = "SELECT * FROM users ORDER BY points DESC LIMIT $limit";
        $statement = $db->prepare($sql);
        $statement->execute();

        $usuarios = [];

        while (($data = $statement->fetch())) {
            $usuarios[] = self::parseUserFromData($data);
        }

        return $usuarios;
    }
}