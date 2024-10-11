<?php

require_once __DIR__ . '/routes.php';
require_once __DIR__ . '/autoload.php';

function route($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        $controller = $routes[$uri][0];
        $method = $routes[$uri][1];
        
        $controller = 'controllers\\' . $controller;
        
        $controllerInstance = new $controller();
        $controllerInstance->$method();
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}

$uri = $_SERVER['REQUEST_URI'];
$uri = strtok($uri, '?');
$uri = rtrim($uri, '/');

if (empty($uri)) {
    $uri = '/';
}

route($uri, $routes);
