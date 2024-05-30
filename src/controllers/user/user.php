<?php

namespace Application\Controllers\User;

require_once('src/lib/database.php');
require_once('src/model/user.php');
require_once('src/model/hickescomments.php');
require 'vendor/autoload.php';

use Application\Lib\Database\DatabaseConnection;
use Application\Model\User as UserModel;
use Application\Model\Login as UserLogin;
use Application\Model\HikesComments as HikesCommentsModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
                            'sess_user' => $nickname
                        ];

                        $mail = new PHPMailer(true);

                        try {
                            //Server settings
                            $mail->isSMTP();                                            //Send using SMTP
                            $mail->Host       = 'live.smtp.mailtrap.io';                      //Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            $mail->Username   = 'api';                               //SMTP username
                            $mail->Password   = 'd9cd774fa76ca46bec6b3241cccab631'; //SMTP password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable explicit TLS encryption
                            $mail->Port       = 587;                                    //TCP port to connect to

                            //Recipients
                            $mail->setFrom('live.smtp.mailtrap.io', 'Eno&Damien');
                            $mail->addAddress($email);                                  //Add a recipient

                            //Content
                            $mail->isHTML(true);                                        //Set email format to HTML
                            $mail->Subject = 'Welcome to our website!';
                            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                            $mail->send();
                            echo 'Message has been sent';
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
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

        //we check if the user connected is an admin, if yes, he will be able to edit and delete comments (see hikesdetails.view.php) condition || ($user_admin == "1")
        $newData = new UserModel($databaseConnection);
        $user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
        $user_admin = $newData->getUserAdminStatus($user_id);

        require(__DIR__ . '/../../view/user/showprofil.view.php');
    }

    public function SaveProfil($userid, $input, $env, $action)
    {
        $databaseConnection = new DatabaseConnection($env);
        $newData = new UserModel($databaseConnection);

        if ($action == 'deleteprofil') {
            $newData->DeleteUser($userid);

            //we delete all comments of the user (model hikescomments.php)
            $newData = new HikesCommentsModel($databaseConnection);
            $newData->delAllCommentHicke($userid);

            session_destroy();
            echo "<script>window.location.href='" . BASE_PATH . "'</script>";
            exit();
        }

        $firstname = htmlspecialchars($input['firstname']);
        $lastname = htmlspecialchars($input['lastname']);
        $nickname = htmlspecialchars($input['nickname']);
        $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);

        //we check if the user connected is an admin, if yes, he will be able to edit and delete comments (see hikesdetails.view.php) condition || ($user_admin == "1")
        $newData = new UserModel($databaseConnection);
        $user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
        $user_admin = $newData->getUserAdminStatus($user_id);

        $newData->SaveUserInfos($userid, $firstname, $lastname, $nickname, $email);

        if ($action == 'saveprofil') {
            $user_infos = $newData->getUserInfos($userid);
        }
        require(__DIR__ . '/../../view/user/showprofil.view.php');
    }
}
