<?php

require_once __DIR__ . '/routes.php';
require_once __DIR__ . '/autoload.php';

function route($uri, $routes) {
    $method = $_SERVER['REQUEST_METHOD']; 

    if (array_key_exists($uri, $routes)) {
        $controller = $routes[$uri][0];
        $action = $routes[$uri][1];
        
        $controllerClass = 'controllers\\' . $controller;
        
        if (class_exists($controllerClass)) {
            $controllerInstance = new $controllerClass();
            
            if (method_exists($controllerInstance, $action)) {
                $controllerInstance->$action();
            } else {
                header("HTTP/1.0 404 Not Found");
                echo "404 Method Not Found";
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Controller Not Found";
        }
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
