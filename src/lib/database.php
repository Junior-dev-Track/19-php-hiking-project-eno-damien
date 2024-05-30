<?php

namespace Application\Lib\Database;

class DatabaseConnection
{
    private $env; // Store environment variables as a class property
    private $pdo;

    public function __construct(array $env)
    { // Pass environment variables through the constructor
        $this->env = $env;
    }

    public function getConnection(): \PDO
    {
        // Now you can access $env directly since it's stored as a class property
        if (isset($this->env['host_name'], $this->env['host_user'], $this->env['host_pwd'], $this->env['host_dbname'])) {
            $this->database = new \PDO("mysql:host={$this->env['host_name']};dbname={$this->env['host_dbname']}", $this->env['host_user'], $this->env['host_pwd']);
        } else {
            throw new \Exception("Impossible de charger les variables d'environnement ou des variables requises manquantes.");
        }

        return $this->database;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
