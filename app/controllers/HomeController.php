<?php
namespace controllers;

use models\LowonganModel;
use core\Request;

class HomeController extends Controller {
    protected $lowonganModel;

    public function __construct() {
        $this->lowonganModel = new LowonganModel();
    }

    public function index() {
        $this->views('home');
    }

    public function getLowongan() {
        try {
            $search = $_GET['search'] ?? ''; 
            $jobType = isset($_GET['jobType']) ? explode(',', $_GET['jobType']) : [];  
            $locationType = isset($_GET['jobPlace']) ? explode(',', $_GET['jobPlace']) : []; 
            $sort = $_GET['sort'] ?? 'asc'; 

            $lowonganList = $this->lowonganModel->getFilteredLowongan($search, $jobType, $locationType, $sort);

            header('Content-Type: application/json');
            echo json_encode($lowonganList);
        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}