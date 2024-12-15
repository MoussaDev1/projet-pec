<?php

namespace App\Controllers\Auth;

use App\Lib\Views;
use App\Models\User;

class LoginController
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login()
    {
        session_start();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $_SESSION['errorLogin'] = [];

            if (empty($email)) {
                $_SESSION['errorLogin']['email'][] = "L'email est obligatoire.";
            }
            if (empty($password)) {
                $_SESSION['errorLogin']['password'][] = "Le mot de passe est obligatoire.";
            }

            if (!empty($_SESSION['errorLogin'])) {
                header('Location: /ProjetPec/public/login');
                exit;
            }


            $loggedUsers = $this->user->login($email, $password);
            if ($loggedUsers) {
                $_SESSION['user'] = $loggedUsers;
                header('Location: /ProjetPec/public/home');
                exit;
            } else {
                $_SESSION['errorLogin']['general'][] = "Identifiants incorrects.";
                header('Location: /ProjetPec/public/login');
                exit;
            }
        } else {
            $errorConn = $_SESSION['errorLogin'] ?? null;
            unset($_SESSION['errorLogin']);
            Views::render('login', ['errorLogin' => $errorConn]);
        }
    }
}
