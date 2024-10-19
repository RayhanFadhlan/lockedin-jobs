<?php
namespace controllers;

use helpers\Redirect;
use models\LowonganModel;
use core\Request;

class HomeController extends Controller {
    protected $lowonganModel;
    protected $itemsPerPage = 10;

    public function __construct() {
        $this->lowonganModel = new LowonganModel();
    }

    public function index() {
        $request = new Request();

        if(isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] === 'company') {
                Redirect::to('/company');
            }
        }
        
        if ($request->getMethod() === 'GET' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->getLowongan($request);
        } else {
            $this->views('home');
        }
    }

    public function getLowongan($request) {
        try {
            $search = $request->getBody('search') ?? '';
            $jobType = isset($_GET['jobType']) ? explode(',', $_GET['jobType']) : [];
            $locationType = isset($_GET['jobPlace']) ? explode(',', $_GET['jobPlace']) : [];
            $sort = $request->getBody('sort') ?? 'asc';
            $page = max(1, intval($request->getBody('page') ?? 1));

            $offset = ($page - 1) * $this->itemsPerPage;

            $lowonganList = $this->lowonganModel->getFilteredLowongan($search, $jobType, $locationType, $sort, $offset, $this->itemsPerPage);
            $totalJobs = $this->lowonganModel->getTotalFilteredJobs($search, $jobType, $locationType);

            $totalPages = ceil($totalJobs / $this->itemsPerPage);

            header('Content-Type: application/json');
            echo json_encode([
                'jobs' => $lowonganList,
                'currentPage' => $page,
                'totalPages' => $totalPages
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function indexCompany() {
        $request = new Request();
        
        if ($request->getMethod() === 'GET' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->getLowonganCompany($request);
        } elseif($request->getMethod() === 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->deleteLowonganCompany($request);
        }else {
            $this->views('home-company');
        }
    }

    public function getLowonganCompany($request) {
        try {
            // $companyId = 28;
            $companyId = $_SESSION['user']['id'];
            $search = $request->getBody('search') ?? '';
            $jobType = isset($_GET['jobType']) ? explode(',', $_GET['jobType']) : [];
            $locationType = isset($_GET['jobPlace']) ? explode(',', $_GET['jobPlace']) : [];
            $sort = $request->getBody('sort') ?? 'asc';
            $page = max(1, intval($request->getBody('page') ?? 1));

            $offset = ($page - 1) * $this->itemsPerPage;

            $lowonganList = $this->lowonganModel->getFilteredLowonganCompany($companyId, $search, $jobType, $locationType, $sort, $offset, $this->itemsPerPage);
            $totalJobs = $this->lowonganModel->getTotalFilteredJobsCompany($companyId, $search, $jobType, $locationType);

            $totalPages = ceil($totalJobs / $this->itemsPerPage);

            header('Content-Type: application/json');
            echo json_encode([
                'jobs' => $lowonganList,
                'currentPage' => $page,
                'totalPages' => $totalPages
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function deleteLowonganCompany() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $lowonganId = $data['lowongan_id'] ?? null;
            
            
            $this->lowonganModel->deleteLowonganById($lowonganId);
    
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Job listing deleted successfully']);
        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}