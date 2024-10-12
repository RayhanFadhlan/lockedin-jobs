<?php

namespace models;

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
        return $stmt->execute([$email, $username, $password, $role]);
    }
}
