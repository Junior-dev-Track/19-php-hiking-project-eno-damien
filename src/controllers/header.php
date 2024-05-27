<?php
namespace Application\Controllers;
// Set session cookie attributes for security
session_set_cookie_params([
    'lifetime' => 3600, // Adjust session lifetime as needed
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => true, // Send cookie over HTTPS only
    'httponly' => true // Prevent JavaScript access to cookie
]);

session_start();

//test de l existence d une session
$user_identifiant = isset($_SESSION['user']['sess_user']) ? $_SESSION['user']['sess_user'] : null;
$user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;

class Header 
{
    public function execute()
    {
        require(__DIR__ . '/../view/header.view.php');
    }
}