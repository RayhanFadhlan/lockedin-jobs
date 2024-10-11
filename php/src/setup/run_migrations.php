<?php

require __DIR__ . '/../autoload.php';

use database\Database;
use database\Migrator;


try {
    $pdo = Database::getInstance()->getConnection();
    $migrator = new Migrator($pdo, __DIR__ . '/../database/migrations');
    $migrator->migrate();

    echo "Migrations completed successfully!" . PHP_EOL;
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . PHP_EOL;
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage() . PHP_EOL;
}