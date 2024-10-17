<?php
namespace database;

use PDO;
use PDOException;
class Database {
    private static $instance = null;
    private $connection;
    private $config;

    private function __construct() {
        $this->config = require __DIR__ . '/../config/setup.php';
        $host = $this->config['host'];
        $port = $this->config['port'];
        $database = $this->config['name'];
        $username = $this->config['username'];
        $password = $this->config['password'];
        try {
            $this->connection = new PDO("pgsql:host=$host;port=$port;dbname=$database;user=$username;password=$password");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}