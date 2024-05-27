<?php

namespace Application\Model;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;
//avoid error using native class PDO
use PDO;

class Login
{
    private string $username;
    private string $password_crypt;
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection(): \PDO
    {
        return $this->connection->getConnection();
    }
    
    public function existEmail($email)
    {
    $statement = $this->connection->getConnection()->prepare("SELECT id, nickname, email, password FROM users WHERE email = :email");
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
    }
}

