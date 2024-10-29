<?php
namespace App\controllers;

use App\models\Finance;

class FinanceController {
    public static function addOperation($sum, $type, $comment): void
    {
        $userId = $_SESSION['userId'];
        if (Finance::add($userId, $sum, $type, $comment)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'fail']);
        }

    }

    public static function getOperations(): void
    {
        $userId = $_SESSION['userId'];
        echo json_encode(Finance::getLatestOperations($userId));
    }

    public static function getSummary(): void
    {
        $userId = $_SESSION['userId'];
        echo json_encode(Finance::getSummary($userId));
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