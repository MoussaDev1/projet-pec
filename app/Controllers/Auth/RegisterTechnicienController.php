<?php

namespace App\Controllers\Auth;

use App\Lib\Views;
use App\Models\User;
use App\Lib\DatabaseSingleton;

class RegisterTechnicienController
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function registerTechnicien()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $specialite = isset($_POST['specialite']) ? implode(', ', $_POST['specialite']) : '';
            $localisation = $_POST['localisation'];
            $_SESSION['errorRegister'] = [];

            $stmt = DatabaseSingleton::getInstance()->getConnection()->prepare('SELECT COUNT(*) FROM utilisateur WHERE email = :email');
            $stmt->execute([':email' => $email]);
            if ($stmt->fetchColumn()) {
                $_SESSION['errorRegister']['email'][] = "Cet email est déjà utilisé.";
                header('Location: /ProjetPec/public/registerTechnicien');
                exit;
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['errorRegister']['email'][] = "Veuillez mettre une adresse email conforme.";
            }

            if (empty($password) || preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
                $_SESSION['errorRegister']['password'][] = "Veuillez mettre un mot de passe conforme.";
            }

            if (empty($nom)) {
                $_SESSION['errorRegister']['nom'][] = "Le nom est obligatoire.";
            }

            if (empty($prenom)) {
                $_SESSION['errorRegister']['prenom'][] = "Le prenom est obligatoire.";
            }

            if (empty($specialite)) {
                $_SESSION['errorRegister']['specialite'][] = "La specialite est obligatoire.";
            }

            if (empty($localisation)) {
                $_SESSION['errorRegister']['localisation'][] = "La localisation est obligatoire.";
            }

            if (!empty($_SESSION['errorRegister'])) {
                header('Location: /ProjetPec/public/registerTechnicien');
                exit;
            }

            try {
                $this->user->registerTechniciens($email, $password, $nom, $prenom, $specialite, $localisation);
                header('Location: /ProjetPec/public/login');
                exit;
            } catch (\PDOException $e) {
                $_SESSION['errorRegister']['general'][] = "Une erreur inattendue s'est produite. Veuillez réessayer.";
                header('Location: /ProjetPec/public/registerTechnicien');
                exit;
            }
        }
        $errorRegister = $_SESSION['errorRegister'] ?? null;
        unset($_SESSION['errorRegister']);
        Views::render('registerTechnicien', ['errorRegister'  => $errorRegister]);
    }
}
