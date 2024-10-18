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

    public function getCompanyProfile($userId) {
        
    }

    public function setCompanyProfile($lokasi, $about) {

    }
}