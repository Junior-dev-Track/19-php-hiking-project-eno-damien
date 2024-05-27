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

(new Header())->execute();

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

//Route matching
$match = $router->match();

if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    echo '<div class="container">
            <div class="text_title">Error 404</div>
            <div class="text_desc">Page not found.</div>
          </div>';
}

(new Footer())->execute();
