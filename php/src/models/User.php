<?php
namespace models;
use database\Database;
class User extends Model {
    public function all() {
        $stmt = $this->db->prepare('SELECT * FROM Users');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}