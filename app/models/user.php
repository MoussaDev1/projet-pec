<?php

namespace App\Models;

use PDO;

class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function register(string $username, string $email, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->pdo->prepare($query);

        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
        ]);
    }

    public function login(string $username, string $password): bool
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user && password_verify($password, $user['password']);
    }
}
