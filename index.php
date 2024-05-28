<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: white;
            transition: width .3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
    <title>Hikes</title>
</head>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//path to the project's root folder (for all the links)
define('BASE_PATH', '/19-php-hiking-project-eno-damien');

require_once __DIR__ . '/vendor/autoload.php';

$envFilePath = '.env';
$env = parse_ini_file($envFilePath);

use Application\Controllers\{
    Header,
    Homepage,
    Footer,
    User\User,
    User\Logout,
    Hikes\HikesDetails,
    Hikes\HikesComments
};

$router = new AltoRouter();
$router->setBasePath('/19-php-hiking-project-eno-damien');

$router->map('GET', '/', function () use ($env) {
    (new Homepage())->execute($env);
});

$router->map('GET', '/login', function () {
    (new User())->login('');
});

//check if methd POST
$router->map('POST', '/login/verification', function () use ($env) {
    (new User())->login($env);
});

//check if methd POST
$router->map('POST', '/sub/verification', function () use ($env) {
    (new User())->register($env);
});

$router->map('GET', '/register', function () {
    (new User())->register('');
});

$router->map('GET', '/logout', function () {
    (new Logout())->execute();
});

$router->map('GET', '/hikes/[i:hikesId]', function ($hikesId) use ($env) {
    (new HikesDetails())->ShowHikes($hikesId, $env);
});

$router->map('POST', '/hikes/addcomment/[i:hikeid]/[i:userid]', function ($hikeid, $userid) use ($env) {
    (new HikesComments())->AddComment($_POST, $hikeid, $userid, $env);
});

$router->map('GET', '/hikes/deletecom/[i:hikeid]/[i:commentid]', function ($hikeid, $commentid) use ($env) {
    (new HikesComments())->DeleteComment($hikeid, $commentid, $env);
});

$router->map('GET', '/hikes/editcom/[i:hikeid]/[i:commentid]', function ($hikeid, $commentid) use ($env) {
    (new HikesComments())->EditComment($hikeid, $commentid, [], 'editCommentHicke', $env);
});

$router->map('POST', '/hikes/editcom/[i:hikeid]/[i:commentid]', function ($hikeid, $commentid) use ($env) {
    (new HikesComments())->EditComment($hikeid, $commentid, $_POST, 'editCommentHickeV', $env);
});

$router->map('GET', '/user/showprofil/[i:userid]', function ($userid) use ($env) {
    (new User())->ShowProfil($userid, $env);
});

$router->map('GET', '/user/editprofil/[i:userid]', function ($userid) use ($env) {
    (new User())->ShowProfil($userid, $env, 'editProfil');
});

//Route matching
$match = $router->match();

if (is_array($match) && is_callable($match['target'])) {
    (new Header())->execute();
    call_user_func_array($match['target'], $match['params']);
    (new Footer())->execute();
} else {
    //Page 404
    require(__DIR__ . '/src/view/404.view.php');
}
