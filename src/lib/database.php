<?php

namespace Application\Lib\Database;

use PDO;

class DatabaseConnection
{
    private $env; // Store environment variables as a class property

    public function __construct(array $env)
    { // Pass environment variables through the constructor
        $this->env = $env;
    }

    public function getConnection(): \PDO
    {
        try {
            // Now you can access $env directly since it's stored as a class property
            if (isset($this->env['host_name'], $this->env['host_user'], $this->env['host_pwd'], $this->env['host_dbname'])) {
                $this->database = new \PDO("mysql:host={$this->env['host_name']};dbname={$this->env['host_dbname']}", $this->env['host_user'], $this->env['host_pwd']);

                $this->database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                //We want any issues to throw an exception with details, instead of a silence or a simple warning
                $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } else {
                throw new \Exception("Impossible de charger les variables d'environnement ou des variables requises manquantes.");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }


        return $this->database;
    }

    public function lastInsertId()
    {
        return $this->database->lastInsertId();
    }

    public function __destruct()
    {
        // Ensure the PDO connection is properly closed when the object is destroyed
        $this->database = null;
    }
}

