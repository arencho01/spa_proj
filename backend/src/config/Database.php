<?php

namespace App\config;

use PDO;
use PDOException;

class Database
{
    private static string $host = "mysql";
    private static string $dbname = "my_db";
    private static string $user = "user";
    private static string $password = "123456";
    private static string $charset = "utf8mb4";
    private static object $conn;

    public function __construct()
    {
        try {
            self::$conn = new PDO(
              "mysql:host=" . self::$host . ":dbname=" . self::$dbname . ";charset=" . self::$charset, self::$user, self::$password
            );
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Ошибка подключения к базе данных: " . $e->getMessage();
        }
    }

    public static function connection(): object
    {
        return self::$conn;
    }
}


//namespace App\config;
//
//use PDO;
//use PDOException;
//
//class Database
//{
//    private $host = 'mysql';
//    private $dbname = 'finance';
//    private $username = 'root';
//    private $password = 'rootpassword';
//    private $conn;
//
//    public function __construct()
//    {
//        try {
//            $this->conn = new PDO(
//                "mysql:host={$this->host};dbname={$this->dbname}",
//                $this->username,
//                $this->password
//            );
//            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        } catch (PDOException $e) {
//            die("Connection failed: " . $e->getMessage());
//        }
//    }
//
//    public function getConnection()
//    {
//        return $this->conn;
//    }
//}