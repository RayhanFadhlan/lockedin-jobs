<?php
namespace controllers;


use exceptions\UnauthorizedException;
use helpers\HTMLSanitizer;
use models\LamaranModel;
use helpers\Redirect;
use core\Request;
use core\Response;
use helpers\Storage;
use models\LowonganModel;
use models\UserModel;
use helpers\CSVExport;

class LamaranController extends Controller {
    protected $lamaranModel;
    protected $itemsPerPage = 10;

    public function __construct() {
        $this->lamaranModel = new LamaranModel();
    }

    public function viewHistory() {
        $request = new Request();
        
        if ($request->getMethod() === 'GET' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->getLamaran($request);
        } else {
            $this->views('history', ['css' => 'history']);
        }
    }

    public function getLamaran(Request $request) {
        try {
            $userId = $_SESSION['user']['id'];

            $search = $request->getBody('search') ?? '';
            $status = isset($_GET['status']) ? explode(',', $_GET['status']) : [];
            $sort = $request->getBody('sort') ?? 'asc';
            $page = max(1, intval($request->getBody('page') ?? 1));

            $offset = ($page - 1) * $this->itemsPerPage;
            $lamaranList = $this->lamaranModel->getDetailLamaran($userId, $search, $status, $sort, $offset);
            $totalLamaran = $this->lamaranModel->getTotalLamaran($userId, $search, $status);
            
            $totalPages = ceil($totalLamaran / $this->itemsPerPage);

            header('Content-Type: application/json');
            echo json_encode([
                'lamaran' => $lamaranList,
                'currentPage' => $page,
                'totalPages' => $totalPages
            ]);
        } catch (\Exception $e) {
            $this->views('/login');
        }
    }

    public function viewCreateLamaran(Request $request,$lowonganId)
    {
        $lowonganModel = new LowonganModel();
        $lowongan = $lowonganModel->getLowonganById($lowonganId);

        if (!$lowongan) {
            return Redirect::withToast('/', 'Job not found');
        }
        
        if($lowongan['is_open'] == 0){
            return Redirect::withToast('/', 'Job is closed');
        }

        $lamaranModel = new LamaranModel();
        $lamaran = $lamaranModel->getLamaranByUserId($_SESSION['user']['id'], $lowonganId);

        if ($lamaran) {
            return Redirect::withToast('/', 'You have already applied for this job', 'error');
        }

        return $this->views("lamaran", [
            'lowonganId' => $lowonganId,
            'posisi' => $lowongan['posisi'],
        ]);
    }

    public function createLamaran(Request $request, $lowonganId){
    try {
        $lowonganModel = new LowonganModel();
        $lowongan = $lowonganModel->getLowonganById($lowonganId);

        if (!$lowongan) {
            throw new \Exception('Job not found');
        }
        
        if($lowongan['is_open'] == 0){
            throw new \Exception('Job is closed');
        }

        $lamaranModel = new LamaranModel();
        $lamaran = $lamaranModel->getLamaranByUserId($_SESSION['user']['id'], $lowonganId);

        if ($lamaran) {
            throw new \Exception('You have already applied for this job');
        }


        if (empty($request->getBody('email')) || !filter_var($request->getBody('email'), FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Email is required and must be a valid email.');
        }

        if (!isset($_FILES['pdf-file']) || $_FILES['pdf-file']['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('PDF file is required and must be a valid PDF.');
        }

        $userId = $_SESSION['user']['id'];

        $storageCv = new Storage('storage/cv/');

        $cvPath = $storageCv->store(['attachment' => $_FILES['pdf-file']])[0];

        $storageVideos = new Storage('storage/videos/');

        $videoPath = null;
        if (isset($_FILES['video-file']) && $_FILES['video-file']['error'] === UPLOAD_ERR_OK) {
            $videoPath = $storageVideos->store(['attachment' => $_FILES['video-file']])[0];
        }

        $lamaranId = $lamaranModel->insertLamaran($userId, $lowonganId, $cvPath, $videoPath);

        Redirect::withToast('/', 'Application submitted successfully', 'success');

        // Response::json([
        //     'success' => true,
        //     'message' => 'Application submitted successfully',
            
        // ])->send();

    } catch (\Exception $e) {
        // Response::json([
        //     'success' => false,
        //     'message' => $e->getMessage()
        // ], 400)->send();
        Redirect::withToast('/', $e->getMessage(), 'error');
        }

    }
    
    public function viewLamaranCompany(Request $request, $id){

        $currentUser = $_SESSION['user']['id'];


        $lamaran = $this->lamaranModel->getLamaranByLamaranId($id);

        if (!$lamaran) {
            return Redirect::withToast('/company', 'Lamaran not found');
        }

        $userModel = new UserModel();

        $user = $userModel->find($lamaran['user_id']);

        $lowonganModel = new LowonganModel();
        $lowongan = $lowonganModel->getLowonganById($lamaran['lowongan_id']);

        if($lowongan['company_id'] !== $currentUser){
            return Redirect::withToast('/company', 'Unauthorized');
        }
        $HTMLSanitizer = new HTMLSanitizer();

        if($lamaran['status']!= 'waiting'){
            $statusReason = $HTMLSanitizer->sanitize($lamaran['status_reason']);
        }else{
            $statusReason = '';
        }

        return $this->views('company/lamaran-detail', [
            'email' => $user['email'],
            'name' => $user['nama'],
            'cv_path' => '/' . $lamaran['cv_path'],
            'video_path' => '/' . $lamaran['video_path'],
            'status' => $lamaran['status'],
            'lowongan' => $lowongan,
            'status_reason' => $statusReason
        ]);
    }

    public function changeLamaranStatus(Request $request, $id){
        try {
        $currentUser = $_SESSION['user']['id'];
        
        
        $request->validate([
            'status' => ['required'],
        ]);

        $status = $request->getBody('status');
        $status_reason = $request->getBody('status_reason');

        $lamaran = $this->lamaranModel->getLamaranByLamaranId($id);

        if (!$lamaran) {
           throw new \Exception('Lamaran not found');
        }

        $lowonganModel = new LowonganModel();
        $lowongan = $lowonganModel->getLowonganById($lamaran['lowongan_id']);

        if($lowongan['company_id'] !== $currentUser){
           throw new \Exception('Unauthorized');
        }

        if (!$lamaran) {
            Response::json([
                'success' => false,
                'message' => 'Lamaran not found'
            ], 404)->send();
        }

        $this->lamaranModel->updateStatus($id, $status, $status_reason);

        Response::json([
            'success' => true,
            'message' => 'Status updated successfully'
        ])->send();


        } catch (\Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400)->send();
        }
    }

    private function getBaseUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        return $protocol . $host;
    }

    public function exportLamaranCSV(Request $request, $id){

        try {
            $currentUser = $_SESSION['user']['id'];
            
            $lowongan = new LowonganModel();
            $lowongan = $lowongan->getLowonganById($id);

            if($lowongan['company_id'] !== $currentUser){
                return Redirect::withToast('/company', 'Unauthorized');
            }


            $lamaranModel = new LamaranModel();
            $lamarans = $lamaranModel->getLamaranForCSV($id);

            $baseUrl = $this->getBaseUrl();
            $processedLamarans = [];
            foreach ($lamarans as $lamaran) {
                $lamaran['cv_path'] = $baseUrl . '/' . $lamaran['cv_path'];
                $lamaran['video_path'] = $baseUrl . '/' . $lamaran['video_path'];
                $processedLamarans[] = $lamaran;
            }
        
            
            $headers = ['nama', 'posisi', 'tanggal_melamar', 'cv_path', 'video_path', 'status'];
        
            
            $csvExport = new CSVExport($processedLamarans, $headers);
            
            $csvExport->export('lamaran_' . $id . '.csv');
        } catch (\Exception $e) {
            return Redirect::withToast('/company', $e->getMessage());
        }
    }

}