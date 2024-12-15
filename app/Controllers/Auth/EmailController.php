<?php

namespace App\Controllers\Auth;

use App\Lib\Views;
use App\Lib\DatabaseSingleton;
use PDO;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;


class EmailController
{

    public function sendValidationEmail(string $to, string $prenom, string $nom, string $token): bool
    {
        $validationLink = "http://localhost/ProjetPec/public/validationEmail?token=" . $token;
        $subject = "Validation de votre adresse email";
        $message = "
            <html>
            <head><title>Validation de votre adresse email</title></head>
            <body>
            <p>Bonjour $prenom $nom,</p>
            <p>Veuillez valider votre adresse email en cliquant sur le lien suivant :</p>
            <p><a href='$validationLink'>$validationLink</a></p>
            <p>Merci de vous être inscrit chez nous !</p>
            </body>
            </html>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@votre-domaine.com" . "\r\n";

        $mail = new PHPMailer(true);

        try {
            // Paramètres du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Serveur SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'moussa.diakitevh@gmail.com';  // Ton email Gmail
            $mail->Password = 'uisq dhho qeoy gfqg';  // Ton mot de passe Gmail (ou mot de passe spécifique si 2FA activée)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataire
            $mail->setFrom('not-reply@doc2wheel.com', 'Doc2Wheel');
            $mail->addAddress($to, "$prenom $nom");

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Envoi de l'email
            if ($mail->send()) {
                return true;  // Email envoyé avec succès
            }
        } catch (Exception $e) {
            // En cas d'erreur
            echo "Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
            return false;  // Envoi échoué
        }
        return false;  // Par défaut, retourner false si l'envoi échoue
    }

    public function getTokenByEmail(string $email)
    {
        $query = "SELECT token_validation FROM utilisateur WHERE email = :email";
        $stmt = DatabaseSingleton::getInstance()->getConnection()->prepare($query);
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result || empty($result['token_validation'])) {
            throw new Exception("Token non trouvé pour l'utilisateur avec l'email $email.");
        }

        return $result['token_validation'];
    }

    public function verifyEmailToken(string $token)
    {
        $query = "SELECT * FROM utilisateur WHERE token_validation = :token";
        $stmt = DatabaseSingleton::getInstance()->getConnection()->prepare($query);
        $stmt->execute([':token' => $token]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validateEmail()
    {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];

            $user = $this->verifyEmailToken($token);

            if ($user) {
                $query = "UPDATE utilisateur SET email_verified = 1, token_validation = NULL WHERE id = :userId";
                $stmt = DatabaseSingleton::getInstance()->getConnection()->prepare($query);
                $stmt->execute([':userId' => $user['id']]);

                Views::render('validationEmail', ['success' => true]);
            } else {
                echo "Le mail de validation a expiré ou est invalide. Veuillez réessayer. <a href='/ProjetPec/public/registerClient'>Inscrivez-vous ici</a>";
            }
        } else {
            echo "Aucun token fourni.";
        }
    }
}
