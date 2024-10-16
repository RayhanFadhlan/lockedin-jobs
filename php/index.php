<?php

require_once __DIR__ . '/autoload.php';

use core\App;

$app = new App();


$app->router->get('/', ['HomeController', 'index']);
$app->router->get('/about', ['AboutController', 'index']);

// Auth
$app->router->get('/signup', ['AuthController', 'viewRegister']);
$app->router->post('/signup', ['AuthController', 'register']);
$app->router->get('/login', ['AuthController', 'viewLogin']);
$app->router->post('/login', ['AuthController', 'login']);

$app->router->get('/home', ['HomeController', 'getLowongan']);

// Job
$app->router->get('/company/createjob', ['JobController', 'viewCreateJob']);

$app->router->get('/company', ['HomeController','indexCompany']);
$app->router->get('/home/company', ['HomeController', 'getLowonganCompany']);
$app->router->post('/company', ['HomeController', 'deleteLowonganCompany']);

$app->run();