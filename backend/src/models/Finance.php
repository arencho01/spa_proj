<?php
namespace App\models;

use App\config\Database;

class Finance {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connection();
    }

    public function add($sum, $type, $comment): bool
    {
        $stmt = "
                    INSERT INTO finance_operations (sum, type, comment) 
                    VALUES (:sum, :type, :comment)
                ";

        $stmt = $this->db->prepare($stmt);
        $stmt->execute(['sum' => $sum, 'type' => $type, 'comment' => $comment]);
        return $stmt->execute();
    }

    public function getLatestOperations($userId) {
        $stmt = "
                    SELECT *
                    FROM finance_operations
                    WHERE user_id = :userId
                    ORDER BY date
                    DESC
                    LIMIT 10
                ";
        $stmt = $this->db->prepare($stmt);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

//    public function getSummary($userId) {
//        $incomeStmt = $this->db->prepare("SELECT SUM(amount) FROM finance_operations WHERE user_id = :user_id AND type = 'income'");
//        $expenseStmt = $this->db->prepare("SELECT SUM(amount) FROM finance_operations WHERE user_id = :user_id AND type = 'expense'");
//
//        $incomeStmt->execute(['user_id' => $userId]);
//        $expenseStmt->execute(['user_id' => $userId]);
//
//        return [
//            'totalIncome' => $incomeStmt->fetchColumn(),
//            'totalExpenses' => $expenseStmt->fetchColumn()
//        ];
//    }
//
//    public function deleteOperation($operationId) {
//        $stmt = $this->db->prepare("DELETE FROM finance_operations WHERE id = :id");
//        return $stmt->execute(['id' => $operationId]);
//    }
}