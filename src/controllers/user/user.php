<?php

namespace Application\Controllers\User;

require_once('src/lib/database.php');
require_once('src/model/user.php');
require_once('src/model/hickescomments.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\User as UserModel;
use Application\Model\Login as UserLogin;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use PDO;

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
                        'sess_user' => $result['nickname']
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
                        $id = $newData->addUser($nickname, $email, $password_crypt, $user_admin);
                        //Autologin after subscription
                        
                        $_SESSION['user'] = [
                            'sess_id' => $id,
                            'sess_user' => $nickname
                        ];
                       
                    

                        // Send email after successful registration
                        // $phpmailer = new PHPMailer();
                        // $phpmailer->isSMTP();
                        // $phpmailer->Host = 'smtp.enkelan.tech';
                        // $phpmailer->SMTPAuth = true;
                        // $phpmailer->Port = 587;
                        // $phpmailer->Username = 'api';
                        // $phpmailer->Password = 'YMYdG$R9';
                        // $phpmailer->setFrom('eno@enkelan.tech', 'Mailer');
                        // $phpmailer->addAddress($email, $nickname);     // Add a recipient
                        // $phpmailer->isHTML(true);                      // Set email format to HTML
                        // $phpmailer->Subject = 'Welcome to our website!';
                        // $phpmailer->Body    = 'This is the HTML message body <b>in bold!</b>';
                        // $phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';
                        // $phpmailer->send();
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
        $databaseConnection = new DatabaseConnection($env);
        $newData = new UserModel($databaseConnection);

        if ($action == 'deleteprofil') {
            $newData->DeleteUser($userid);
            
            session_destroy();
            echo "<script>window.location.href='" . BASE_PATH . "'</script>";
            exit();
        }

        $firstname = htmlspecialchars($input['firstname']);
        $lastname = htmlspecialchars($input['lastname']);
        $nickname = htmlspecialchars($input['nickname']);
        $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);

        $newData->SaveUserInfos($userid, $firstname, $lastname, $nickname, $email);

        if ($action == 'saveprofil') {
            $user_infos = $newData->getUserInfos($userid);
            $successMessage = "Profile edited successfully.";
        }

       
        require(__DIR__ . '/../../view/user/showprofil.view.php');
    }
}
