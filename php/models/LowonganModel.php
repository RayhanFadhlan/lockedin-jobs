<?php

namespace models;
use PDO;
class LowonganModel extends Model {

    public function getLowonganById($id) {
        $query = 'SELECT * FROM "Lowongan" WHERE lowongan_id = :lowonganID';
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':lowonganID', $id);

        $stmt->execute();
        
        return $stmt->fetch();
    }
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

    public function getFilteredLowonganCompany($companyId, $search = '', $jobType = [], $locationType = [], $sort = 'asc', $offset = 0, $limit = 10) {
        $query = 'SELECT * FROM "Lowongan" WHERE company_id = :companyId AND is_open = TRUE';
        $params = [':companyId' => $companyId];
    
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
    
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);
    
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getTotalFilteredJobsCompany($companyId, $search = '', $jobType = [], $locationType = []) {
        $query = 'SELECT COUNT(*) FROM "Lowongan" WHERE company_id = :companyId AND is_open = TRUE';
        $params = [':companyId' => $companyId];
    
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
    
    public function deleteLowonganById($lowonganId) {
        $stmt = $this->db->prepare('DELETE FROM "Lowongan" WHERE lowongan_id = :lowonganId');
        $stmt->bindParam(':lowonganId', $lowonganId);
        $stmt->execute();
    }
    public function insertLowongan($userId,$jobPosition, $jobType, $jobLocation, $jobDescription) {
        $stmt = $this->db->prepare('INSERT INTO "Lowongan" (company_id, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi) VALUES (:company_id, :posisi, :deskripsi, :jenis_pekerjaan, :jenis_lokasi)');
        $stmt->bindValue(':company_id', $userId);
        $stmt->bindValue(':posisi', $jobPosition);
        $stmt->bindValue(':deskripsi', $jobDescription);
        $stmt->bindValue(':jenis_pekerjaan', $jobType);
        $stmt->bindValue(':jenis_lokasi', $jobLocation);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    public function insertAttachmentLowongan($lowonganId, $attachmentPaths) {
        $stmt = $this->db->prepare('INSERT INTO "AttachmentLowongan" (lowongan_id, file_path) VALUES (:lowongan_id, :path)');
        foreach ($attachmentPaths as $path) {
            $stmt->bindValue(':lowongan_id', $lowonganId);
            $stmt->bindValue(':path', $path);
            $stmt->execute();
        }
    }

    public function getAttachments($id){
        $stmt = $this->db->prepare('SELECT * FROM "AttachmentLowongan" WHERE lowongan_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function closeLowongan($lowonganId) {
        $stmt = $this->db->prepare('UPDATE "Lowongan" SET is_open = FALSE WHERE lowongan_id = :lowonganId');
        $stmt->bindParam(':lowonganId', $lowonganId);
        $stmt->execute();
    }

    public function openLowongan($lowonganId) {
        $stmt = $this->db->prepare('UPDATE "Lowongan" SET is_open = TRUE WHERE lowongan_id = :lowonganId');
        $stmt->bindParam(':lowonganId', $lowonganId);
        $stmt->execute();
    }

    public function getLowonganAttachments($lowonganId) {
        $stmt = $this->db->prepare('SELECT "file_path" FROM "AttachmentLowongan" WHERE lowongan_id = :lowonganId');
        $stmt->bindParam(':lowonganId', $lowonganId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateLowongan($lowonganId, $jobPosition, $jobType, $jobLocation, $jobDescription) {
        $stmt = $this->db->prepare('UPDATE "Lowongan" SET posisi = :posisi, deskripsi = :deskripsi, jenis_pekerjaan = :jenis_pekerjaan, jenis_lokasi = :jenis_lokasi WHERE lowongan_id = :lowonganId');
        $stmt->bindParam(':lowonganId', $lowonganId);
        $stmt->bindParam(':posisi', $jobPosition);
        $stmt->bindParam(':deskripsi', $jobDescription);
        $stmt->bindParam(':jenis_pekerjaan', $jobType);
        $stmt->bindParam(':jenis_lokasi', $jobLocation);
        $stmt->execute();
    }

    public function deleteAttachments($lowonganId) {
        $stmt = $this->db->prepare('DELETE FROM "AttachmentLowongan" WHERE lowongan_id = :lowonganId');
        $stmt->bindParam(':lowonganId', $lowonganId);
        $stmt->execute();
    }
}