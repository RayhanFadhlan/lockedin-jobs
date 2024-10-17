<?php

namespace database;

use PDO;

class Migrator {
    private $pdo;
    private $migrationsPath;

    public function __construct(PDO $pdo, string $migrationsPath) {
        $this->pdo = $pdo;
        $this->migrationsPath = $migrationsPath;
    }

    public function migrate() {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        
        $files = scandir($this->migrationsPath);
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            $this->applyMigration($migration);
            $this->saveMigration($migration);
            
            echo "Applied migration: $migration" . PHP_EOL;
        }
    }

    private function createMigrationsTable() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id SERIAL PRIMARY KEY,
            migration VARCHAR(255),
            applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    private function getAppliedMigrations() {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    private function applyMigration($migration) {
        $sql = file_get_contents($this->migrationsPath . DIRECTORY_SEPARATOR . $migration);
        $this->pdo->exec($sql);
    }

    private function saveMigration($migration) {
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
        $statement->execute(['migration' => $migration]);
    }
}