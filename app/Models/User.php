<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

class User extends PDOException
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function registerClient(string $email, string $password, string $nom, string $prenom, string $adresse, int $telephone)
    {

        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $role = '1';
            $token = bin2hex(random_bytes(32));
            $query = "INSERT INTO utilisateur (email, mot_de_passe, role, token_validation) VALUES (:email, :password, :role, :token)";
            $stmt = $this->pdo->prepare($query);

            $stmt->execute([
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role,
                ':token' => $token,
            ]);
            $userId = $this->pdo->lastInsertId();

            $query = "INSERT INTO client (user_id, nom, prenom, adresse, telephone) VALUES (:id, :nom, :prenom, :adresse, :telephone)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':id' => $userId,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':adresse' => $adresse,
                ':telephone' => $telephone,
            ]);
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de la création du compte: " . $e->getMessage(), (int) $e->getCode());
        }
    }

    public function registerTechniciens(string $email, string $password, string $nom, string $prenom, string $specialite, string $localisation)
    {

        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $role = '2';
            $query = "INSERT INTO utilisateur (email, mot_de_passe, role) VALUES (:email, :password, :role)";
            $stmt = $this->pdo->prepare($query);

            $stmt->execute([
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role,
            ]);
            $userId = $this->pdo->lastInsertId();

            $query = "INSERT INTO technicien (user_id, nom, prenom, specialite, localisation) VALUES (:id, :nom, :prenom, :specialite, :localisation)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':id' => $userId,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':specialite' => $specialite,
                ':localisation' => $localisation,
            ]);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getMessage());
        }
    }




    public function login(string $email, string $password): ?array
    {
        $query = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'],
            ];
        }
        return null;
    }
}
