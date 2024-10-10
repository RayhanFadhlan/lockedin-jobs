<?php

// return [
//     'host' => 'localhost',
//     'port' => '5432',
//     'database' => 'testing',
//     'username' => 'postgres',
//     'password' => 'root'
// ];

use setup\EnvLoader;

(new EnvLoader(__DIR__.'/.env'))->load();
define('host', getenv('DB_HOST'));
define('port', getenv('DB_PORT'));
define('database', getenv('DB_NAME'));
define('username', getenv('DB_USER'));
define('password', getenv('DB_PASSWORD'));