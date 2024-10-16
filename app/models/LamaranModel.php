<?php

namespace models;

class LamaranModel extends Model {

    public function getFilteredLamaran($user_id, $search = '', $status = [], $sort = 'asc', $offset = 0, $limit = 10) {
        $query = 'SELECT * FROM "Lamaran" WHERE user_id = :usedID';
        $params = [];

        if (!empty($search)) {
            $query .= " AND LOWER(posisi) LIKE :search";
            $params[':search'] = '%' . strtolower($search) . '%';
        }

        if (!empty($status)) {
            $placeholders = implode(',', array_map(function($i) { return ':status'.$i; }, array_keys($status)));
            $query .= " AND LOWER(status) IN ($placeholders)";
            foreach ($status as $i => $type) {
                $params[':status'.$i] = strtolower($type);
            }
        }

        $query .= " ORDER BY created_at " . ($sort === 'desc' ? 'DESC' : 'ASC');
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

    public function getTotalFilteredLamaran($user_id, $search = '', $status = []) {
        $query = 'SELECT COUNT(*) FROM "Lamaran" WHERE user_id = :usedID';
        $params = [];

        if (!empty($search)) {
            $query .= " AND LOWER(posisi) LIKE :search";
            $params[':search'] = '%' . strtolower($search) . '%';
        }

        if (!empty($status)) {
            $placeholders = implode(',', array_map(function($i) { return ':status'.$i; }, array_keys($status)));
            $query .= " AND LOWER(status) IN ($placeholders)";
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

    public function createLamaran($user_id, $lowongan_id, $cv_path='', $video_path='', $status, $status_reason='') {
        $stmt = $this->db->prepare('INSERT INTO "Lamaran" (user_id, lowongan_id, cv_path, video_path, status, status_reason) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user_id, $lowongan_id, $cv_path, $video_path, $status, $status_reason]);
        return $this->db->lastInsertId();
    }

    public function updateLamaran($lamaran_id, $cv_path='', $video_path='') {
        $stmt = $this->db->prepare('UPDATE "Lamaran" SET cv_path = ?, video_path = ? WHERE lamaran_id = ?');
        $stmt->execute([$cv_path, $video_path, $lamaran_id]);
        return $stmt->rowCount();
    }
}