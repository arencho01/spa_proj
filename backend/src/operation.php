<?php
session_start();
require_once '../../config/Database.php';
require_once '../../controllers/OperationController.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authorized']);
    exit();
}

$db = (new Database())->connect();
$operationController = new OperationController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->action)) {
        $userId = $_SESSION['user_id'];

        if ($data->action === 'add') {
            if ($operationController->addOperation($userId, $data->amount, $data->type, $data->comment)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add operation']);
            }
        }

        if ($data->action === 'delete') {
            if ($operationController->deleteOperation($data->id, $userId)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete operation']);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_SESSION['user_id'];
    $latestOperations = $operationController->getLatestOperations($userId);
    $summary = $operationController->getSummary($userId);

    echo json_encode(['operations' => $latestOperations, 'summary' => $summary]);
}
