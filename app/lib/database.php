<?php

namespace app\lib;

class Database
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if ($this->database === null) {
            $this->database = new \PDO('mysql:host=localhost;dbname=projet_pec;charset=utf8', 'root', '');
        }

        return $this->database;
    }
}
