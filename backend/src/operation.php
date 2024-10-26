<?php

use App\controllers\FinanceController;

//var_dump($_SESSION);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'auth.php';

$financeController = new FinanceController();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);


    if (isset($data['action']) && $data['action'] === 'add') {
        echo $financeController->addOperation($user_id, $data['sumValue'], $data['typeValue'], $data['commentValue']);
    }

    if (isset($data['action']) && $data['action'] == 'getLatest') {
        echo $financeController->getOperations($user_id);
    }

    if (isset($data['action']) && $data['action'] == 'delete') {

        echo $financeController->deleteOperation($data['operationId']);
    }

    if (isset($data['action']) && $data['action'] == 'summary') {
        echo $financeController->getSummary($user_id);
    }
}
