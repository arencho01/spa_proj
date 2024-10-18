<?php
//include_once 'config/db.php';

use App\config\db;

function addOperation($userId, $amount, $type, $comment) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO finance_operations (user_id, amount, type, comment) VALUES (:user_id, :amount, :type, :comment)");
    return $stmt->execute([
        'user_id' => $userId,
        'amount' => $amount,
        'type' => $type,
        'comment' => $comment
    ]);
}

function getOperations($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM finance_operations WHERE user_id = :user_id ORDER BY date DESC LIMIT 10");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSummary($userId) {
    global $pdo;
    $incomeStmt = $pdo->prepare("SELECT SUM(amount) FROM finance_operations WHERE user_id = :user_id AND type = 'income'");
    $expenseStmt = $pdo->prepare("SELECT SUM(amount) FROM finance_operations WHERE user_id = :user_id AND type = 'expense'");

    $incomeStmt->execute(['user_id' => $userId]);
    $expenseStmt->execute(['user_id' => $userId]);

    return [
        'totalIncome' => $incomeStmt->fetchColumn(),
        'totalExpenses' => $expenseStmt->fetchColumn()
    ];
}