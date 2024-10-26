<?php
namespace App\models;

use App\config\Database;
use PDO;

class Finance {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connection();
    }

    public function add($user_id, $sum, $type, $comment): bool
    {
        $stmt = "
                    INSERT INTO finance_operations (user_id, sum, type, comment) 
                    VALUES (:user_id, :sum, :type, :comment)
                ";

        $stmt = $this->db->prepare($stmt);
        return $stmt->execute(['user_id' => $user_id, 'sum' => $sum, 'type' => $type, 'comment' => $comment]);
    }

    public function getLatestOperations($userId): false|array
    {
        $stmt = "
                    SELECT *
                    FROM finance_operations
                    WHERE user_id = :userId
                    ORDER BY date
                    DESC
                    LIMIT 10
                ";

        $stmt = $this->db->prepare($stmt);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSummary($userId) {
        $incomeStmt = "
                            SELECT SUM(sum)
                            FROM finance_operations
                            WHERE user_id = :userId
                            AND type = 'приход'
                       ";
        $expenseStmt = "
                            SELECT SUM(sum)
                            FROM finance_operations
                            WHERE user_id = :userId
                            AND type = 'расход'
                        ";

        $incomeStmt = $this->db->prepare($incomeStmt);
        $expenseStmt = $this->db->prepare($expenseStmt);

        $incomeStmt->execute(['userId' => $userId]);
        $expenseStmt->execute(['userId' => $userId]);

        return [
            'totalIncome' => $incomeStmt->fetchColumn(),
            'totalExpenses' => $expenseStmt->fetchColumn()
        ];
    }

    public function deleteOperation($operationId) {
        $stmt = "
                    DELETE FROM finance_operations
                    WHERE id = :operationId
                ";

        $stmt = $this->db->prepare($stmt);
        return $stmt->execute(['operationId' => $operationId]);
    }
}