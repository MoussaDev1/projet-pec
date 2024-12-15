<?php

namespace App\Lib;

class DatabaseSingleton
{
    private static ?DatabaseSingleton $instance = null;
    private ?\PDO $DatabaseSingleton = null;

    private function __construct() {} // Empêche l'instanciation directe

    public static function getInstance(): ?DatabaseSingleton
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): \PDO
    {
        if ($this->DatabaseSingleton === null) {
            $this->DatabaseSingleton = new \PDO('mysql:host=localhost;dbname=projet_pec;charset=utf8', 'root', '', [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
        }

        return $this->DatabaseSingleton;
    }
}
