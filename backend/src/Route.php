<?php
namespace App;

use App\controllers\AuthController;
use App\controllers\FinanceController;

class Route {
    public static function handleRequest(): void
    {

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $action = $data['action'];

        switch ($action) {
            case 'auth':
                AuthController::auth();
                break;

            case 'register':
                AuthController::register($data['login'], $data['password']);
                break;

            case 'login':
                AuthController::login($data['login'], $data['password']);
                break;

            case 'logout':
                AuthController::logout();
                break;

            case 'add-operation':
                FinanceController::addOperation($data['sumValue'], $data['typeValue'], $data['commentValue']);
                break;

            case 'get-latest':
                FinanceController::getOperations();
                break;

            case 'get-summary':
                FinanceController::getSummary();
                break;

            case 'delete-operation':
                FinanceController::deleteOperation($data['operationId']);
                break;

            default:
                echo json_encode(['error' => 'Action не найден']);
        }
    }
}
