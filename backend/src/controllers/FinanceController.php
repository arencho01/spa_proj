<?php
namespace App\controllers;

use App\models\Finance;

class FinanceController {
    private $financeModel;

    public function __construct() {
        $this->financeModel = new Finance();
    }

    public function addOperation($sum, $type, $comment) {
        if ($this->financeModel->add($sum, $type, $comment)) {
            return json_encode(['status' => 'success']);
        }

        return json_encode(['status' => 'fail']);
    }

    public function getOperations($userId) {
        return $this->financeModel->getLatestOperations($userId);
    }

//    public function getSummary($userId) {
//        return $this->financeModel->getSummary($userId);
//    }
//
//    public function deleteOperation($operationId) {
//        return $this->financeModel->deleteOperation($operationId);
//    }
}




//require_once '../models/Operation.php';
//
//class OperationController
//{
//    private $operation;
//
//    public function __construct($db)
//    {
//        $this->operation = new Operation($db);
//    }
//
//    public function addOperation($userId, $amount, $type, $comment)
//    {
//        return $this->operation->addOperation($userId, $amount, $type, $comment);
//    }
//
//    public function getLatestOperations($userId)
//    {
//        return $this->operation->getLatestOperations($userId);
//    }
//
//    public function deleteOperation($operationId, $userId)
//    {
//        return $this->operation->deleteOperation($operationId, $userId);
//    }
//
//    public function getSummary($userId)
//    {
//        return $this->operation->getSummary($userId);
//    }
//}