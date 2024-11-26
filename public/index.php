<?php

// Inclure les fichiers nécessaires
require_once 'C:\xampp\htdocs\ProjetPec\app\lib\database.php';
require_once 'C:\xampp\htdocs\ProjetPec\app\models\user.php';
require_once 'C:\xampp\htdocs\ProjetPec\app\controllers\AuthController.php';

use app\lib\Database;
use app\models\User;
use app\controllers\AuthController;

$database = new Database();
$pdo = $database->getConnection();

$user = new User($pdo);

$authController = new AuthController($user);

$action = $_GET['action'] ?? null;

if ($action === 'login') {
    $authController->login();
} elseif ($action === 'register') {
    $authController->register();
} else {
    echo "Bienvenue sur la page d'accueil";
}
