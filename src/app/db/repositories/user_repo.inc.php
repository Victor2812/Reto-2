<?php

abstract class UserRepository {
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

        return null;
    }

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

    public static function getFollowersInfo(UserEntity $user, int $limit = 4) {
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
            $follower[] = new UserEntity(
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

        return $follower;
    }

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
            $following[] = new UserEntity(
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

        
        return $following;
    }

    public static function getFollowersCount(UserEntity $user) {
        global $db;

        $sql = 'SELECT count(source) FROM followers WHERE destination = :id';

        $statement = $db->prepare($sql);
        $statement->execute([
            'id' => $user->getId()
        ]);

        $data = $statement->fetch();

        return $data;
    }

    public static function getFollowingCount(UserEntity $user) {
        global $db;

        $sql = 'SELECT count(destination) FROM followers WHERE source = :id';

        $statement = $db->prepare($sql);
        $statement->execute([
            'id' => $user->getId()
        ]);

        $data = $statement->fetch();

        return $data;
    }
}