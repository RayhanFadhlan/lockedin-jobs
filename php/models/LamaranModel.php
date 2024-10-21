<?php

namespace models;
use PDO;

class LamaranModel extends Model {

    public function getDetailLamaran($user_id, $search = '', $status = [], $sort = 'asc', $offset = 0, $limit = 10) {
        $query = 'SELECT lm.lowongan_id, lm.status, lm.created_at, lw.posisi, u.nama FROM "Lamaran" lm JOIN "Lowongan" lw ON lm.lowongan_id = lw.lowongan_id JOIN "User" u ON lw.company_id = u.user_id WHERE lm.user_id = :userID';
        $params = [];

        if (!empty($search)) {
            $query .= " AND u.nama LIKE :search";
            $params[':search'] = '%' . strtolower($search) . '%';
        }

        if (!empty($status)) {
            $placeholders = implode(',', array_map(function($i) { return ':status'.$i; }, array_keys($status)));
            $query .= " AND LOWER(status) IN ($placeholders)";
            foreach ($status as $i => $type) {
                $params[':status'.$i] = strtolower($type);
            }
        }

        $query .= " ORDER BY lm.created_at " . ($sort === 'desc' ? 'DESC' : 'ASC');
        $query .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':userID', $user_id);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);

        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getTotalLamaran($user_id, $search = '', $status = []) {
        $query = 'SELECT COUNT(*) FROM "Lamaran" lm JOIN "Lowongan" lw ON lm.lowongan_id = lw.lowongan_id JOIN "User" u ON lw.company_id = u.user_id WHERE lm.user_id = :userID';
        $params = [];

        if (!empty($search)) {
            $query .= " AND u.nama LIKE :search";
            $params[':search'] = '%' . strtolower($search) . '%';
        }

        if (!empty($status)) {
            $placeholders = implode(',', array_map(function($i) { return ':status'.$i; }, array_keys($status)));
            $query .= " AND lm.status IN ($placeholders)";
            foreach ($status as $i => $type) {
                $params[':status'.$i] = strtolower($type);
            }
        }

        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':userID', $user_id);

        $stmt->execute();
        
        return $stmt->fetchColumn();
    }

    public function createLamaran($user_id, $lowongan_id, $status, $cv_path='', $video_path='', $status_reason='') {
        $stmt = $this->db->prepare('INSERT INTO "Lamaran" (user_id, lowongan_id, cv_path, video_path, status, status_reason) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user_id, $lowongan_id, $cv_path, $video_path, $status, $status_reason]);
        return $this->db->lastInsertId();
    }

    public function updateLamaran($lamaran_id, $cv_path='', $video_path='') {
        $stmt = $this->db->prepare('UPDATE "Lamaran" SET cv_path = ?, video_path = ? WHERE lamaran_id = ?');
        $stmt->execute([$cv_path, $video_path, $lamaran_id]);
        return $stmt->rowCount();
    }

    public function insertLamaran($userId, $lowonganId, $cvPath = null, $videoPath = null) {
        $stmt = $this->db->prepare('INSERT INTO "Lamaran" (user_id, lowongan_id, cv_path, video_path, status, created_at) 
                                    VALUES (?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$userId, $lowonganId, $cvPath, $videoPath, 'waiting']);
        return $this->db->lastInsertId();
    }
    
    public function getLamaranByUserId($userId) {
        $stmt = $this->db->prepare('SELECT * FROM "Lamaran" WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getLamaranById($id) {
        $stmt = $this->db->prepare('SELECT * FROM "Lamaran" WHERE lamaran_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getLamaransByLowonganId($lowonganId) {
        $stmt = $this->db->prepare('SELECT * FROM "Lamaran" WHERE lowongan_id = ? ORDER BY created_at DESC');
        $stmt->execute([$lowonganId]);
        return $stmt->fetchAll();
    }

    public function getLamaranByLamaranId($lamaranId){
        $stmt = $this->db->prepare('SELECT * FROM "Lamaran" WHERE lamaran_id = ?');
        $stmt->execute([$lamaranId]);
        return $stmt->fetch();
    }

    public function updateStatus($lamaranId, $status, $statusReason = '') {
        $stmt = $this->db->prepare('UPDATE "Lamaran" SET status = ?, status_reason = ? WHERE lamaran_id = ?');
        $stmt->execute([$status, $statusReason, $lamaranId]);
        
    }

    public function getLamaransNameStatus($lowonganId){
        $stmt = $this->db->prepare('SELECT u.nama, l.status, l.lamaran_id FROM "Lamaran" l JOIN "User" u ON l.user_id = u.user_id WHERE l.lowongan_id = ?');
        $stmt->execute([$lowonganId]);
        return $stmt->fetchAll();
    }

    public function getLamaranForCSV($lowonganId){
        $stmt = $this->db->prepare(
            'SELECT u.nama, lw.posisi, l.created_at, l.cv_path, l.video_path, l.status 
             FROM "Lamaran" l 
             JOIN "User" u ON l.user_id = u.user_id 
             JOIN "Lowongan" lw ON l.lowongan_id = lw.lowongan_id 
             WHERE l.lowongan_id = ?'
        );
        $stmt->execute([$lowonganId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}