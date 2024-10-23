<?php

namespace App\config;

use App\models\User;

class Validator
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function validateRegisterFields($name, $password, $confirmPass): array
    {
        $errors = [];

        $name = Validator::sanitizeInput($name) ?? '';
        $password = Validator::sanitizeInput($password) ?? '';
        $confirmPass = Validator::sanitizeInput($confirmPass) ?? '';


        if (empty($name)) {
            $errors['userName'] = 'Это поле обязательно для заполнения';
        } elseif ($this->userModel->isUserNameTaken($name)) {
            $errors['userName'] = 'Пользователь с таким логином уже существует';
        }

        if (empty($confirmPass)) {
            $errors['userPassConfirm'] = 'Это поле обязательно для заполнения';
        }

        if (empty($password)) {
            $errors['userPass'] = 'Это поле обязательно для заполнения';
        } elseif ($password != $confirmPass) {
            $errors['userPassConfirm'] = 'Пароли не совпадают';
        }

        return $errors;
    }

    public function validateLoginFields($name, $password): array
    {
        $errors = [];
        var_dump(json_encode($name));
        var_dump(json_encode($this->userModel->isUserNameTaken($name)));

        if (empty($name)) {
            $errors['userName'] = 'Это поле обязательно для заполнения';
        } elseif (!$this->userModel->isUserNameTaken($name)) {
            $errors['userName'] = 'Пользователя с таким логином не существует';
        }

        if (empty($password)) {
            $errors['userPass'] = 'Это поле обязательно для заполнения';
        }

        if (!empty($name) && $this->userModel->getUserPassword($name) != $password) {
            $errors['userPass'] = 'Неправильный пароль';
        }

        return $errors;
    }

    public static function sanitizeInput($input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES);
    }
}
