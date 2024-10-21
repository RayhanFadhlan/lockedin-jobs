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
            $this->views('history', ['css' => 'home']);
        }
    }

    public function getLamaran(Request $request) {
        try {
            // $userId = $_SESSION('user_id') ?? -999;
            $userId = 1;
            if ($userId === -999) {return new UnauthorizedException('Login untuk melihat riwayat lamaran');}

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
            return Redirect::withToast('/login', $e->getMessage());
        }
    }

    public function viewCreateLamaran($lowonganId)
    {
        return $this->views("lamaran", [
            'lowonganId' => $lowonganId
        ]);
    }

    public function createLamaran(Request $request, $lowonganId){
    try {
        if (empty($request->getBody('email')) || !filter_var($request->getBody('email'), FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Email is required and must be a valid email.');
        }

        if (!isset($_FILES['pdf-file']) || $_FILES['pdf-file']['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('PDF file is required and must be a valid PDF.');
        }

        $userId = $_SESSION['user']['id'];

        $storage = new Storage();

        $cvPath = $storage->store(['attachment' => $_FILES['pdf-file']])[0];

        $videoPath = null;
        if (isset($_FILES['video-file']) && $_FILES['video-file']['error'] === UPLOAD_ERR_OK) {
            $videoPath = $storage->store(['attachment' => $_FILES['video-file']])[0];
        }

        $lamaranModel = new LamaranModel();
        $lamaranId = $lamaranModel->insertLamaran($userId, $lowonganId, $cvPath, $videoPath);

        Redirect::withToast('/', 'Application submitted successfully');

        Response::json([
            'success' => true,
            'message' => 'Application submitted successfully',
            
        ])->send();

    } catch (\Exception $e) {
        Response::json([
            'success' => false,
            'message' => $e->getMessage()
        ], 400)->send();
        }

    }
    
    public function viewLamaranCompany(Request $request, $id){

        $currentUser = $_SESSION['user']['id'];


        $lamaran = $this->lamaranModel->getLamaranByLamaranId($id);

        if (!$lamaran) {
            return Redirect::withToast('/company', 'Job not found');
        }

        $userModel = new UserModel();

        $user = $userModel->find($lamaran['user_id']);

        $lowonganModel = new LowonganModel();
        $lowongan = $lowonganModel->getLowonganById($lamaran['lowongan_id']);

        if($lowongan['company_id'] !== $currentUser){
            return Redirect::withToast('/company', 'Unauthorized');
        }
        $HTMLSanitizer = new HTMLSanitizer();


        return $this->views('company/lamaran-detail', [
            'email' => $user['email'],
            'name' => $user['nama'],
            'cv_path' => '/' . $lamaran['cv_path'],
            'video_path' => '/' . $lamaran['video_path'],
            'status' => $lamaran['status'],
            'lowongan' => $lowongan,
            'status_reason' => $HTMLSanitizer->sanitize($lamaran['status_reason'])
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
            return Redirect::withToast('/company', 'Lamaran not found');
        }

        $lowonganModel = new LowonganModel();
        $lowongan = $lowonganModel->getLowonganById($lamaran['lowongan_id']);

        if($lowongan['company_id'] !== $currentUser){
            return Redirect::withToast('/company', 'Unauthorized');
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
}