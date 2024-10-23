<?php

use App\App;

require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'models/FinanceOperation.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/FinanceController.php';
require_once 'App.php';

$app = new App();
$app->handleRequest();
