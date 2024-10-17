<?php

namespace models;
use PDO;
class UserModel extends Model {
     public function checkEmailExists($email) {
        $stmt = $this->db->prepare('SELECT * FROM "User" WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function checkUsernameExists($username) {
        $stmt = $this->db->prepare('SELECT * FROM "User" WHERE nama = ?');
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function createUser($email, $username, $password, $role) {
        $stmt = $this->db->prepare('INSERT INTO "User" (email, nama, password, role) VALUES (?, ?, ?, ?)');
        $stmt->execute([$email, $username, $password, $role]);
        return $this->db->lastInsertId();
    }

    public function find($id) {
        $stmt = $this->db->prepare('SELECT * FROM "User" WHERE user_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


}
