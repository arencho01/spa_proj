<?php
namespace App\controllers;

use App\models\Finance;
use App\controllers\AuthController;

class FinanceController {
    public static function addOperation($sum, $type, $comment): void
    {
        $userId = $_SESSION['userId'];
        if (Finance::add($userId, $sum, $type, $comment)) {
            echo json_encode(['status' => 'success']);
        }

        echo json_encode(['status' => 'fail']);
    }

    public static function getOperations(): void
    {
        $userId = $_SESSION['userId'];
        echo json_encode(Finance::getLatestOperations($userId));
    }

    public static function getSummary(): void
    {
        $userId = $_SESSION['userId'];

        $results = Finance::getSummary($userId);
        if ($results['totalIncome'] == null) {
            $results['totalIncome'] = '0';
        }
        if ($results['totalExpenses'] == null) {
            $results['totalExpenses'] = '0';
        }
        echo json_encode($results);
    }

    public static function deleteOperation($operationId): void
    {
        if(Finance::deleteOperation($operationId)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'fail']);
        }
    }
}