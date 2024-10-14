<?php

namespace models;

class LowonganModel extends Model {

    public function getFilteredLowongan($search = '', $jobType = [], $locationType = [], $sort = 'asc') {
        $query = 'SELECT * FROM "Lowongan" WHERE is_open = TRUE';

        if (!empty($search)) {
            $query .= " AND LOWER(posisi) LIKE :search";
        }

        if (!empty($jobType)) {
            $query .= " AND LOWER(jenis_pekerjaan) IN (" . implode(',', array_fill(0, count($jobType), '?')) . ")";
        }

        if (!empty($locationType)) {
            $query .= " AND LOWER(jenis_lokasi) IN (" . implode(',', array_fill(0, count($locationType), '?')) . ")";
        }

        $query .= " ORDER BY created_at " . ($sort === 'desc' ? 'DESC' : 'ASC');

        $stmt = $this->db->prepare($query);

        $paramIndex = 1;
        if (!empty($search)) {
            $stmt->bindValue(':search', '%' . strtolower($search) . '%');
        }

        foreach (array_merge($jobType, $locationType) as $param) {
            $stmt->bindValue($paramIndex++, $param);
        }

        $stmt->execute();
        
        return $stmt->fetchAll();
    }

}