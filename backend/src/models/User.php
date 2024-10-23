<?php
namespace App\models;

use App\config\Database;
use PDO;
use PDOException;

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connection();
    }

//    public function findByUsername($username) {
//        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
//        $stmt->execute(['username' => $username]);
//        return $stmt->fetch();
//    }

//    public function create($username, $password) {
//        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
//        return $stmt->execute(['username' => $username, 'password' => $hashedPassword]);
//    }

    public function isUserNameTaken($username): bool
    {
        $stmt = "
                    SELECT COUNT(*)
                    FROM `users`
                    WHERE `name` = :username
                ";

        $stmt = $this->db->prepare($stmt);
        $stmt->execute(["username" => $username]);

        return $stmt->fetchColumn() > 0;
    }

    public function getUserPassword($username)
    {
        $stmt = "
                    SELECT `password`
                    FROM users
                    WHERE `name` = :username
                    LIMIT 1
                ";
        $stmt = $this->db->prepare($stmt);
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['password'];
    }

//    public function addUser($username, $password)
//    {
//        $stmt = "
//                    INSERT INTO `users` (name, password)
//                    VALUES (:username, :password)
//                ";
//    }


}