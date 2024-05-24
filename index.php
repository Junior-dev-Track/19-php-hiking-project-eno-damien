<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';

$envFilePath = '.env';
$env = parse_ini_file($envFilePath);

use Application\Controllers\{
    Header,
    Homepage,
    Footer,
    User\User
};

(new Header())->execute();

$router = new AltoRouter();
$router->setBasePath('/19-php-hiking-project-eno-damien');

$router->map('GET', '/', function () use ($env) {
    (new Homepage())->execute($env);
});

$router->map('GET', '/login', function () {
    (new User())->login();
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
