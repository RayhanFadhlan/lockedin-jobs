<?php

namespace models;

class CompanyProfileModel extends Model {

    public function getCompanyDetail($userId) {
        $stmt = $this->db->prepare('SELECT "lokasi", "about" FROM "CompanyDetail" WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    public function getCompanyNama($userId) {
        $stmt = $this->db->prepare('SELECT "nama" FROM "User" WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    public function setCompanyProfile($userId, $name, $lokasi, $about) {
        $stmt = $this->db->prepare('UPDATE "User" SET nama = ? WHERE user_id = ?');
        $stmt->execute([$name, $userId]);
        $stmt = $this->db->prepare('UPDATE "CompanyDetail" SET lokasi = ?, about = ? WHERE user_id = ?');
        $stmt->execute([$lokasi, $about, $userId]);
        return $stmt->rowCount();
    }
}