<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\controllers\TestController;
use App\controllers\AuthController;

require_once __DIR__ . '/../../vendor/autoload.php';


session_start();
//require 'config/Database.php';
//require 'controllers/AuthController.php';


$authController = new AuthController();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    echo $authController->login($data['login'], $data['password']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}