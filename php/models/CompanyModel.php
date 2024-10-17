<?php

namespace models;

class CompanyModel extends Model {

    public function getCompany($id) {
        $stmt = $this->db->prepare('SELECT * FROM "Company" WHERE user_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createCompany($userId, $lokasi, $about) {
        $stmt = $this->db->prepare('INSERT INTO "CompanyDetail" (user_id, lokasi, about) VALUES (?, ?, ?)');
        return $stmt->execute([$userId, $lokasi, $about]);
    }
}