<?php

namespace Application\Model;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;
//avoid error using native class PDO
use PDO;

class User
{
    private string $firstname;
    private string $lastname;
    private string $nickname;
    private string $email;
    private string $password_crypt;
    private int $user_admin;
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection(): \PDO
    {
        return $this->connection->getConnection();
    }
    
    public function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    //check if email is already ind db
    public function checkDuplicateMail($email)
    {
    $statement = $this->connection->getConnection()->prepare("SELECT COUNT(*) from users WHERE email = :email");
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchColumn();
    return $result;
    }

    //check if nickname is already ind db
    public function checkDuplicateUser($nickname)
    {
    $statement = $this->connection->getConnection()->prepare("SELECT COUNT(*) from users WHERE nickname = :nickname");
    $statement->bindParam(':nickname', $nickname, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchColumn();
    return $result;
    }

    public function addUser($nickname, $email, $password_crypt)
    {
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO users (nickname, email, password) VALUES (:nickname, :email , :password_crypt)"
        );
        $statement->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password_crypt', $password_crypt, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

