<?php
//namespace App;
//
//use App\controllers\AuthController;
//use App\controllers\FinanceController;
//
//class App {
//    public function handleRequest() {
//        $action = $_POST['action'] ?? '';
//        $authController = new AuthController();
//        $financeController = new FinanceController();
//
//        var_dump('asdasd');
//
//        switch ($action) {
//            case 'login':
//                echo 'hello';
//                $data = json_decode(file_get_contents('php://input'), true);
//                echo json_encode($authController->login($data['username'], $data['password']));
//                break;
//
//            case 'register':
//                $data = json_decode(file_get_contents('php://input'), true);
//                echo json_encode($authController->register($data['username'], $data['password']));
//                break;
//
//            case 'add-operation':
//                $data = json_decode(file_get_contents('php://input'), true);
//                $userId = 1;  // предполагаем, что пользователь авторизован
//                echo json_encode($financeController->addOperation($userId, $data['amount'], $data['type'], $data['comment']));
//                break;
//
//            case 'get-operations':
//                $userId = 1;  // предполагаем, что пользователь авторизован
//                echo json_encode(['operations' => $financeController->getOperations($userId)]);
//                break;
//
//            case 'get-summary':
//                $userId = 1;  // предполагаем, что пользователь авторизован
//                echo json_encode($financeController->getSummary($userId));
//                break;
//
//            case 'delete-operation':
//                $id = $_GET['id'];
//                echo json_encode($financeController->deleteOperation($id));
//                break;
//
//            default:
//                echo json_encode(['error' => 'Action not found']);
//        }
//    }
//}
