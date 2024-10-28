<?php

namespace App\config;

use App\models\User;

class Validator
{
    public static function validateRegisterFields($name, $password): array
    {
        $errors = [];

        if (empty($name)) {
            $errors['userName'] = 'Это поле обязательно для заполнения';
        } elseif (User::isUserNameTaken($name)) {
            $errors['userName'] = 'Пользователь с таким логином уже существует';
        }

        if (empty($password)) {
            $errors['userPass'] = 'Это поле обязательно для заполнения';
        }

        return $errors;
    }

    public static function validateLoginFields($name, $password): array
    {
        $errors = [];

        if (empty($name)) {
            $errors['userName'] = 'Это поле обязательно для заполнения';
        } elseif (!User::isUserNameTaken($name)) {
            $errors['userName'] = 'Пользователя с таким логином не существует';
        }

        if (empty($password)) {
            $errors['userPass'] = 'Это поле обязательно для заполнения';
        }

        if (User::isUserNameTaken($name) && !password_verify($password, User::getUserPassword($name))) {
            $errors['userPass'] = 'Неправильный пароль';
        }

        return $errors;
    }

    public static function sanitizeInput($input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES);
    }
}
