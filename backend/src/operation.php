<?php

use App\controllers\FinanceController;

require_once __DIR__ . '/../../vendor/autoload.php';

$financeController = new FinanceController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);


    if (isset($data['action']) && $data['action'] === 'add') {
//        echo json_encode($data);
        echo $financeController->addOperation($data['sum'], $data['type'], $data['comment']);
    }

    if (isset($data['action']) && $data['action'] == 'getLatest') {
        echo json_encode($data);
        echo $financeController->getOperations()
    }
}
