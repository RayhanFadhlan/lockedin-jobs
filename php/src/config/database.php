<?php

return [
    'host' => getenv('DB_HOST'),
    'port' => getenv('DB_PORT'),
    'name' => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD')
];
