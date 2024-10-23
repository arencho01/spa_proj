<?php
namespace App\controllers;

//use App\config\Database;
//use App\models\User;
use PDO;
use PDOException;


class TestController {

    private static string $host = "mysql";
    private static string $dbname = "finances";
    private static string $user = "user";
    private static string $password = "123456";
    private static string $charset = "utf8mb4";
    public static object $conn;

    public function __construct()
    {
//        try {
//            self::$conn = new PDO(
//                "mysql:host=" . self::$host . ":dbname=" . self::$dbname . ";charset=" . self::$charset, self::$user, self::$password
//            );
//            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        } catch (PDOException $e) {
//            echo "Ошибка подключения к базе данных: " . $e->getMessage();
//        }
    }

//    public static function connection(): object
//    {
//        return self::$conn;
//    }



    public function login() {

        return json_encode('huy');
    }

    public function test() {
        try {
            self::$conn = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset, self::$user, self::$password
            );
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Ошибка подключения к базе данных: " . $e->getMessage();
        }
        $db = self::$conn;
        $stmt = $db->prepare("SELECT * FROM `users`");
        $stmt->execute();
        $result = $stmt->fetchAll();
//        return json_encode($result);
        return json_encode('huy');
    }
}