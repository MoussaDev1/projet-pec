<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
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
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->user->login($username, $password)) {
                $_SESSION['username'] = $username;
                header('Location: /dashboard');
                exit;
            } else {
                echo "Identifiants incorrects.";
            }
        } else {
            require_once __DIR__ . '/../views/login.php';
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            try {
                $this->user->register($username, $email, $password);
                header('Location: /ProjetPec/public/login');
                exit;
            } catch (\Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            require_once __DIR__ . '/../views/register.php';
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
