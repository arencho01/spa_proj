<?php
namespace App\controllers;

use App\models\User;
use App\config\Validator;

class AuthController {

    public static function register($username, $password): void
    {
        $name = Validator::sanitizeInput(($username), ENT_QUOTES) ?? '';
        $password = Validator::sanitizeInput(($password), ENT_QUOTES) ?? '';

        $errors = Validator::validateRegisterFields($name, $password);

        if (!empty($errors)) {
            echo json_encode(['status' => 'fail', 'errors' => $errors], JSON_UNESCAPED_UNICODE);
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            User::addUser($username, $hashedPassword);

            $userId = User::getUserId($username);
            $_SESSION['user'] = $username;
            $_SESSION['userId'] = $userId;

            echo json_encode(['status' => 'success', 'user' => $username, 'user_id' => $userId], JSON_UNESCAPED_UNICODE);
        }
    }

    public static function login($username, $password): void
    {
        $name = Validator::sanitizeInput(($username), ENT_QUOTES) ?? '';
        $password = Validator::sanitizeInput(($password), ENT_QUOTES) ?? '';

        $errors = Validator::validateLoginFields($name, $password);


        if(!empty($errors)) {
            echo json_encode(['status' => 'fail', 'errors' => $errors], JSON_UNESCAPED_UNICODE);
        } else {
            $userId = User::getUserId($username);

            $_SESSION['user'] = $username;
            $_SESSION['userId'] = $userId;

            echo json_encode(['status' => 'success', 'user' => $username, 'user_id' => $userId], JSON_UNESCAPED_UNICODE);
        }
    }

    public static function auth(): void
    {
        if (!empty($_SESSION['user'])) {
            $response = $_SESSION['user'];
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode('', JSON_UNESCAPED_UNICODE);
        }
    }

    public static function logout(): void
    {
        $_SESSION['user'] = null;
        $_SESSION['userId'] = null;

        $response = [];
        $response['user'] = $_SESSION['user'];
        $response['userId'] = $_SESSION['userId'];

        echo json_encode(['status' => 'success', 'session' => $response], JSON_UNESCAPED_UNICODE);
    }
}