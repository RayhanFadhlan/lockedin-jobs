<?php

namespace models;

class LowonganModel extends Model {

    public function getFilteredLowongan($search = '', $jobType = [], $locationType = [], $sort = 'asc', $offset = 0, $limit = 10) {
        $query = 'SELECT * FROM "Lowongan" WHERE is_open = TRUE';
        $params = [];

        if (!empty($search)) {
            $query .= " AND LOWER(posisi) LIKE :search";
            $params[':search'] = '%' . strtolower($search) . '%';
        }

        if (!empty($jobType)) {
            $placeholders = implode(',', array_map(function($i) { return ':jobType'.$i; }, array_keys($jobType)));
            $query .= " AND LOWER(jenis_pekerjaan) IN ($placeholders)";
            foreach ($jobType as $i => $type) {
                $params[':jobType'.$i] = strtolower($type);
            }
        }

        if (!empty($locationType)) {
            $placeholders = implode(',', array_map(function($i) { return ':locationType'.$i; }, array_keys($locationType)));
            $query .= " AND LOWER(jenis_lokasi) IN ($placeholders)";
            foreach ($locationType as $i => $type) {
                $params[':locationType'.$i] = strtolower($type);
            }
        }

        $query .= " ORDER BY created_at " . ($sort === 'desc' ? 'DESC' : 'ASC');
        $query .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', $limit,);
        $stmt->bindValue(':offset', $offset);

        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getTotalFilteredJobs($search = '', $jobType = [], $locationType = []) {
        $query = 'SELECT COUNT(*) FROM "Lowongan" WHERE is_open = TRUE';
        $params = [];

        if (!empty($search)) {
            $query .= " AND LOWER(posisi) LIKE :search";
            $params[':search'] = '%' . strtolower($search) . '%';
        }

        if (!empty($jobType)) {
            $placeholders = implode(',', array_map(function($i) { return ':jobType'.$i; }, array_keys($jobType)));
            $query .= " AND LOWER(jenis_pekerjaan) IN ($placeholders)";
            foreach ($jobType as $i => $type) {
                $params[':jobType'.$i] = strtolower($type);
            }
        }

        if (!empty($locationType)) {
            $placeholders = implode(',', array_map(function($i) { return ':locationType'.$i; }, array_keys($locationType)));
            $query .= " AND LOWER(jenis_lokasi) IN ($placeholders)";
            foreach ($locationType as $i => $type) {
                $params[':locationType'.$i] = strtolower($type);
            }
        }

        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        
        return $stmt->fetchColumn();
    }

    public function getLowonganById($lowonganId) {
        $query = 'SELECT * FROM "Lowongan" WHERE lowongan_id = :lowonganId';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':lowonganId', $lowonganId);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function getLamaranByJobSeeker($userId, $lowonganId) {
        $query = 'SELECT * FROM "Lamaran" WHERE user_id = :userId AND lowongan_id = :lowonganId';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':lowonganId', $lowonganId);
        $stmt->execute();
        
        return $stmt->fetch();
    }
}