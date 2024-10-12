<?php

require_once __DIR__ . '/autoload.php';

use core\App;

$app = new App();

// Define routes
$app->router->get('/', ['HomeController', 'index']);
$app->router->get('/about', ['AboutController', 'index']);
// $app->router->get('/login', ['LoginController', 'index'], ['AuthMiddleware']);
$app->router->get('/signup', ['SignupController', 'index']);
$app->router->post('/signup', ['SignupController', 'store']);


$app->run();