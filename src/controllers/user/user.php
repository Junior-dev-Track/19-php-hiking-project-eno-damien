<?php

namespace Application\Controllers\User;

require_once('src/lib/database.php');
require_once('src/model/user.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\User as UserModel;
use Application\Model\Login as UserLogin;

class User
{
    public function login($env)
    { {
            $error = '';
            if (isset($_POST['email'], $_POST['password'])) {
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $password_crypt = password_hash($password, PASSWORD_DEFAULT);

                $databaseConnection = new DatabaseConnection($env);
                $newData = new UserLogin($databaseConnection);

                $result = $newData->existEmail($email);
                if ($result && password_verify($password, $result['password'])) {

                    // Regenerate session ID to mitigate session fixation attacks
                    session_regenerate_id(true);

                    // store data of user in $_SESSION
                    $_SESSION['user'] = [
                        'sess_id' => $result['id'],
                        'sess_user' => $result['nickname'],
                        'sess_admin' => $result['user_admin']
                    ];

                    $success_login = "Login Successfull.";
                    $success_welcome = "Welcome " . htmlspecialchars($result['nickname']);
                } else {
                    $error = "Invalid email or password. Retry.";
                }
            } else {
                $error = "No data received";
            }
            require(__DIR__ . '/../../view/user/login.view.php');
        }
    }

    public function register($env)
    {
        $error = '';
        if (isset($_POST['nickname'], $_POST['email'], $_POST['password'])) {
            $nickname = htmlspecialchars($_POST['nickname']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = htmlspecialchars($_POST['password']);
            $password_crypt = password_hash($password, PASSWORD_DEFAULT);

            $databaseConnection = new DatabaseConnection($env);
            $newData = new UserModel($databaseConnection);

            if (!$newData->isValidEmail($email)) {
                $error = "The entered email address is not valid.";
            } else {
                // check if nickname is already in the database
                $nickname_verif = $newData->checkDuplicateUser($nickname);
                if ($nickname_verif > 0) {
                    $error = "User already exists. Please, choose another login !";
                } else {
                    // check if email is already in the database
                    $email_verif = $newData->checkDuplicateMail($email);
                    if ($email_verif > 0) {
                        $error = "Email already exists. Please, choose another mail or retrieve your informations!";
                    } else {

                        $userCount = $newData->firstUser();
                        $user_admin = ($userCount == 0) ? 1 : 0;

                        $newData->addUser($nickname, $email, $password_crypt, $user_admin);
                        //Autologin after subscription
                        $id = $databaseConnection->getConnection()->lastInsertId();
                        $_SESSION['user'] = [
                            'sess_id' => $id,
                            'sess_user' => $nickname,
                            'sess_admin' => $user_admin
                        ];
                        var_dump($_SESSION['user']);
                    }
                }
            }
        } else {
            $error = "No data received";
        }
        require(__DIR__ . '/../../view/user/register.view.php');
    }

    public function ShowProfil($userid, $env, $action)
    {
        $databaseConnection = new DatabaseConnection($env);
        $newData = new UserModel($databaseConnection);

        $user_infos = $newData->getUserInfos($userid);

        require(__DIR__ . '/../../view/user/showprofil.view.php');
    }

    public function SaveProfil($userid, $input, $env, $action)
    {
        $firstname = htmlspecialchars($input['firstname']);
        $lastname = htmlspecialchars($input['lastname']);
        $nickname = htmlspecialchars($input['nickname']);
        $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);

        $databaseConnection = new DatabaseConnection($env);
        $newData = new UserModel($databaseConnection);

        $newData->SaveUserInfos($userid, $firstname, $lastname, $nickname, $email);

        if ($action == 'saveprofil') {
            $user_infos = $newData->getUserInfos($userid);
        }

        if ($action == 'deleteprofil') {
            $newData->DeleteUser($userid);
    
            session_start();
            session_destroy();
            header('Location: ' . BASE_PATH);
            exit();
        }
        require(__DIR__ . '/../../view/user/showprofil.view.php');
    }

}
