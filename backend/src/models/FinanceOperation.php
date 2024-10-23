<?php
namespace App\models;

use App\config\Database;

class FinanceOperation {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function add($userId, $amount, $type, $comment) {
        $stmt = $this->db->prepare("INSERT INTO finance_operations (user_id, amount, type, comment) VALUES (:user_id, :amount, :type, :comment)");
        return $stmt->execute(['user_id' => $userId, 'amount' => $amount, 'type' => $type, 'comment' => $comment]);
    }

    public function getLatestOperations($userId) {
        $stmt = $this->db->prepare("SELECT * FROM finance_operations WHERE user_id = :user_id ORDER BY date DESC LIMIT 10");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getSummary($userId) {
        $incomeStmt = $this->db->prepare("SELECT SUM(amount) FROM finance_operations WHERE user_id = :user_id AND type = 'income'");
        $expenseStmt = $this->db->prepare("SELECT SUM(amount) FROM finance_operations WHERE user_id = :user_id AND type = 'expense'");

        $incomeStmt->execute(['user_id' => $userId]);
        $expenseStmt->execute(['user_id' => $userId]);

        return [
            'totalIncome' => $incomeStmt->fetchColumn(),
            'totalExpenses' => $expenseStmt->fetchColumn()
        ];
    }

    public function deleteOperation($operationId) {
        $stmt = $this->db->prepare("DELETE FROM finance_operations WHERE id = :id");
        return $stmt->execute(['id' => $operationId]);
    }
}