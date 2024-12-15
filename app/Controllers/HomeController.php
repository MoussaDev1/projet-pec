<?php

namespace App\Controllers;

use App\Lib\Views;

class HomeController
{

    public function showHome()
    {
        session_start();
        if (!isset($_SESSION['user']['email']) || !isset($_SESSION['user']['role'])) {
            header('Location: /ProjetPec/public/login');
            exit;
        }

        Views::render('home', ['userLogged' => $_SESSION['user']]);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /ProjetPec/public/login');
        exit;
    }
}
