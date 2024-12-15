<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Auth\EmailController;
use App\Lib\DatabaseSingleton;
use App\Models\User;
use App\Controllers\Auth\LoginController;
use App\Controllers\HomeController;
use App\Controllers\Auth\RegisterClientController;
use App\Controllers\Auth\RegisterTechnicienController;


$database = DatabaseSingleton::getInstance();
$pdo = $database->getConnection();

$user = new User($pdo);
$LoginController = new LoginController($user);
$HomeController = new HomeController();
$emailController = new EmailController();
$RegisterClientController = new RegisterClientController($user, $emailController);
$RegisterTechnicienController = new RegisterTechnicienController($user);

$action = $_GET['action'] ?? null;
$method = $_GET['method'] ?? null;

if ($action === 'registerClient') {
    $RegisterClientController->registerClient();
} elseif ($action === 'registerTechnicien') {
    $RegisterTechnicienController->registerTechnicien();
} elseif ($action === 'login') {
    $LoginController->login();
} elseif ($action === 'home') {
    $HomeController->showHome();
    $userRole = $_SESSION['user']['role'];
    if ($method === 'logout') {
        $HomeController->logout();
    }
} elseif ($action === 'validationEmail' && isset($_GET['token'])) {
    $emailController->validateEmail();
} else {
    $LoginController->login();
}
