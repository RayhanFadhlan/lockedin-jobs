<?php
namespace models;

use database\Database;

class UserModel extends Model {
    public function all() {
        $stmt = $this->db->prepare('SELECT * FROM users');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
