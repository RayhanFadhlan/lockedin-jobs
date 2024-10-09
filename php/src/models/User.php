<?php
namespace models;

use database\Database;
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all() {
        $stmt = $this->db->prepare('SELECT * FROM Users');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}