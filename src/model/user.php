<?php

namespace Application\Model;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;
//avoid error using native class PDO
use PDO;

class User extends DatabaseConnection
{
    private string $firstname;
    private string $lastname;
    private string $nickname;
    private string $email;
    private string $password_crypt;
    private int $user_admin;

    public function __construct(array $env)
    {
        parent::__construct($env);
    }

    public function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    //check if email is already ind db
    public function checkDuplicateMail($email)
    {
        $statement = $this->getConnection()->prepare("SELECT COUNT(*) from users WHERE email = :email");
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchColumn();
        return $result;
    }

    //check if nickname is already ind db
    public function checkDuplicateUser($nickname)
    {
        $statement = $this->getConnection()->prepare("SELECT COUNT(*) from users WHERE nickname = :nickname");
        $statement->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchColumn();
        return $result;
    }

    public function firstUser()
    {
        $statement = $this->getConnection()->prepare("SELECT COUNT(*) from users");
        $statement->execute();
        $result = $statement->fetchColumn();
        return $result;
    }


    public function addUser($nickname, $email, $password_crypt, $user_admin)
    {
        $statement = $this->getConnection()->prepare(
            "INSERT INTO users (nickname, email, password, user_admin) VALUES (:nickname, :email, :password_crypt, :user_admin)"
        );
        $statement->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password_crypt', $password_crypt, PDO::PARAM_STR);
        $statement->bindParam(':user_admin', $user_admin, PDO::PARAM_INT);
        $statement->execute();
       
        // Retrieve the last inserted ID
        $lastInsertId = $this->lastInsertId();
        return $lastInsertId; // Return the last inserted ID
    }
    

    public function getUserInfos($userid)
    {
        $statement = $this->getConnection()->prepare("SELECT id, firstname, lastname, nickname, email, user_admin from users WHERE id = :userid");
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllUserInfos()
    {
        $statement = $this->getConnection()->prepare("SELECT id, firstname, lastname, nickname, email, user_admin 
        from users
        ORDER BY nickname");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function SaveUserInfos($userid, $firstname, $lastname, $nickname, $email)
    {
        $statement = $this->getConnection()->prepare(
            "UPDATE users SET firstname = :firstname, lastname = :lastname, nickname = :nickname, email = :email WHERE id = :userid"
        );
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
        $statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $statement->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $result = $statement->execute();
        return $result;
    }

    public function DeleteUser($userid)
    {
        $statement = $this->getConnection()->prepare("DELETE from users WHERE id = :userid");
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
        $result = $statement->execute();
        return $result;
    }

    public function getUserAdminStatus($user_id)
    {
        $statement = $this->getConnection()->prepare("SELECT user_admin FROM users WHERE id = :user_id");
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchColumn();
        return $result;
    }
}
