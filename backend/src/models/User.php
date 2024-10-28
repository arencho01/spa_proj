<?php
namespace App\models;

use App\config\Database;
use PDO;
use PDOException;

class User {
    public static function isUserNameTaken($username): bool
    {
        $db = Database::connection();
        $stmt = "
                    SELECT COUNT(*)
                    FROM `users`
                    WHERE `name` = :username
                ";

        $stmt = $db->prepare($stmt);
        $stmt->execute(["username" => $username]);

        return $stmt->fetchColumn() > 0;
    }

    public static function getUserPassword($username)
    {
        $db = Database::connection();
        $stmt = "
                    SELECT `password`
                    FROM users
                    WHERE `name` = :username
                    LIMIT 1
                ";
        $stmt = $db->prepare($stmt);
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['password'];
    }

    public static function getUserId($username)
    {
        $db = Database::connection();
        $stmt = "
                    SELECT `id`
                    FROM `users`
                    WHERE `name` = :username
                    LIMIT 1
                ";

        $stmt = $db->prepare($stmt);
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }

    public static function addUser($username, $password): bool
    {
        $db = Database::connection();
        $stmt = "
                    INSERT INTO `users` (name, password)
                    VALUES (:username, :password)
                ";
        $stmt = $db->prepare($stmt);
        return $stmt->execute(['username' => $username, 'password' => $password]);
    }
}