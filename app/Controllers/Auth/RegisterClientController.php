<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Lib\Views;
use App\Lib\DatabaseSingleton;
use Exception;
use App\Controllers\Auth\EmailController;

class RegisterClientController
{
    private User $user;
    private EmailController $emailController;

    public function __construct(User $user, EmailController $emailController)
    {
        $this->user = $user;
        $this->emailController = $emailController;
    }

    public function RegisterClient()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $adresse = $_POST['adresse'];
            $telephone = $_POST['telephone'];
            $_SESSION['errorRegister'] = [];

            $stmt = DatabaseSingleton::getInstance()->getConnection()->prepare('SELECT COUNT(*) FROM utilisateur WHERE email = :email');
            $stmt->execute([':email' => $email]);
            if ($stmt->fetchColumn()) {
                $_SESSION['errorRegister']['email'][] = "Cet email est déjà utilisé.";
                header('Location: /ProjetPec/public/registerClient');
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

            if (empty($adresse)) {
                $_SESSION['errorRegister']['adresse'][] = "L'adresse est obligatoire.";
            }

            if (empty($telephone)) {
                $_SESSION['errorRegister']['telephone'][] = "Le telephone est obligatoire.";
            }

            if (!empty($_SESSION['errorRegister'])) {
                header('Location: /ProjetPec/public/registerClient');
                exit;
            }

            try {
                $this->user->registerClient($email, $password, $nom, $prenom, $adresse, $telephone);
                $token = $this->emailController->getTokenByEmail($email);
                $this->emailController->sendValidationEmail($email, $prenom, $nom, $token);
                echo "Un email de validation a été envoyé à votre adresse email. Veuillez vérifier votre boîte de réception. <a href='/ProjetPec/public/login'>connectez-vous ici</a>";
            } catch (Exception $e) {
                $_SESSION['errorRegister']['general'][] = "Une erreur inattendue s'est produite. Veuillez réessayer.";
                header('Location: /ProjetPec/public/registerClient');
                exit;
            }
        }
        $errorRegister = $_SESSION['errorRegister'] ?? null;
        unset($_SESSION['errorRegister']);
        Views::render('registerClient', ['errorRegister'  => $errorRegister]);
    }
}
