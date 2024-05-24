<?php
require_once __DIR__ . '/vendor/autoload.php';

$envFilePath = '.env';
$env = parse_ini_file($envFilePath);

use Application\Controllers\{
    Header,
    Homepage,
    Footer
};

(new Header())->execute();

$router = new AltoRouter();
//$router->setBasePath('/19-php-hiking-project-eno-damien');

$router->map('GET', '/', function () use ($env) {
    (new Homepage())->execute($env);
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
