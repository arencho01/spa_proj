<?php

use App\controllers\AuthController;


session_start();
//var_dump($_SESSION);
require_once __DIR__ . '/../../vendor/autoload.php';


$authController = new AuthController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);


    if ($data['action'] == 'auth') {
        echo $authController->auth();
    }

    if ($data && isset($data['action']) && $data['action'] === 'login') {
        echo $authController->login($data['login'], $data['password']);
    }

    if ($data && isset($data['action']) && $data['action'] === 'logout') {
        echo $authController->logout();
    }

}