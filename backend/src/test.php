<?php
//
//
//use App\controllers\TestController;
//
//session_start();
//require 'config/Database.php';
//require 'controllers/AuthController.php';
//
//
//$authController = new TestController();
//
//
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    $json = file_get_contents('php://input');
//    $data = json_decode($json, true);
//
//    // Проверим, что данные пришли корректно и содержат нужные поля
//    echo json_encode($data);
//} else {
//    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
//}