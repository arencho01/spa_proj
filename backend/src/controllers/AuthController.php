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

    public function login($username, $password) {
        var_dump($username, $password);
        $user = $this->userModel->findUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            return ['success' => true];
        }

        return ['success' => false];
    }

//    public function register($username, $password) {
//        if ($this->userModel->create($username, $password)) {
//            return ['success' => true];
//        }
//
//        return ['success' => false];
//    }

    public function register()
    {
        if ($this->isMethodPost()) {

            $name = $_POST['name'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];

            $errors = $this->validator->validateRegisterFields($name, $password, $confirmPassword);

            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                if ($this->userModel->addUser($name, $hashedPassword)) {
                    $_SESSION['user'] = $name;
                }
            }

        }
    }

    public function isMethodPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}