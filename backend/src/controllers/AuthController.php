<?php
namespace App\controllers;

use App\models\User;
use App\config\Validator;

class AuthController {
    private $userModel;
    private $validator;

    public function __construct() {
        $this->userModel = new User();
        $this->validator = new Validator();
    }

    public function login($username, $password): false|string
    {
        $name = $this->validator->sanitizeInput(($username), ENT_QUOTES) ?? '';
        $password = $this->validator->sanitizeInput(($password), ENT_QUOTES) ?? '';

        $errors = $this->validator->validateLoginFields($name, $password);


        if(!empty($errors)) {
            return json_encode(['status' => 'fail', 'errors' => $errors], JSON_UNESCAPED_UNICODE);
        } else {
            $_SESSION['user'] = $username;
            return json_encode(['status' => 'success', 'user_session' => $username], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getSession()
    {
        $sessionUserName = $_SESSION['user'];

        return json_encode($_SESSION, JSON_UNESCAPED_UNICODE);
    }







//    public function register($username, $password) {
//        if ($this->userModel->create($username, $password)) {
//            return ['success' => true];
//        }
//
//        return ['success' => false];
//    }
//
//    public function register()
//    {
//        if ($this->isMethodPost()) {
//
//            $name = $_POST['name'];
//            $password = $_POST['password'];
//            $confirmPassword = $_POST['confirmPassword'];
//
//            $errors = $this->validator->validateRegisterFields($name, $password, $confirmPassword);
//
//            if (empty($errors)) {
//                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//
//                if ($this->userModel->addUser($name, $hashedPassword)) {
//                    $_SESSION['user'] = $name;
//                }
//            }
//
//        }
//    }
//
//    public function isMethodPost(): bool
//    {
//        return $_SERVER['REQUEST_METHOD'] === 'POST';
//    }
}