<?php
namespace App\models;

use App\config\Database;
use PDO;

class Finance {

    public static function add($userId, $sum, $type, $comment): bool
    {
        $db = Database::connection();
        $stmt = "
                    INSERT INTO finance_operations (user_id, sum, type, comment) 
                    VALUES (:user_id, :sum, :type, :comment)
                ";

        $stmt = $db->prepare($stmt);
        return $stmt->execute(['user_id' => $userId, 'sum' => $sum, 'type' => $type, 'comment' => $comment]);
    }

    public static function getLatestOperations($userId): false|array
    {
        $db = Database::connection();
        $stmt = "
                    SELECT *
                    FROM finance_operations
                    WHERE user_id = :userId
                    ORDER BY date
                    DESC
                    LIMIT 10
                ";

        $stmt = $db->prepare($stmt);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSummary($userId): array
    {
        $db = Database::connection();
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

        $incomeStmt = $db->prepare($incomeStmt);
        $expenseStmt = $db->prepare($expenseStmt);

        $incomeStmt->execute(['userId' => $userId]);
        $expenseStmt->execute(['userId' => $userId]);

        return [
            'totalIncome' => $incomeStmt->fetchColumn() ?? '0',
            'totalExpenses' => $expenseStmt->fetchColumn() ?? '0'
        ];
    }

    public static function deleteOperation($operationId): bool
    {
        $db = Database::connection();
        $stmt = "
                    DELETE FROM finance_operations
                    WHERE id = :operationId
                ";

        $stmt = $db->prepare($stmt);
        return $stmt->execute(['operationId' => $operationId]);
    }
}