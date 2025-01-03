<?php

use setup\EnvLoader;

// $envPath = isset($_ENV['DOCKER_ENV']) ? '/var/www/html/.env' : __DIR__ . '/../../.env';
// $dbHost = isset($_ENV['DOCKER_ENV']) ? getenv('DB_HOST') : '127.0.0.1';
// (new EnvLoader($envPath))->load();

// return [
//     'host' => $dbHost,
//     'port' => getenv('DB_PORT'),
//     'name' => getenv('DB_NAME'),
//     'username' => getenv('DB_USER'),
//     'password' => getenv('DB_PASSWORD'),
// ];

if(isset($_ENV['DOCKER_ENV'])) {
    return [
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'name' => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
    ];
   
}else {

    $envPath = __DIR__ . '/../../.env';
    (new EnvLoader($envPath))->load();
    return [
        'host' => 'localhost',
        'port' => getenv('DB_PORT'),
        'name' => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
    ];
}