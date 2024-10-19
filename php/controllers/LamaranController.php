<?php
namespace controllers;

use exceptions\UnauthorizedException;
use models\LamaranModel;
use helpers\Redirect;
use core\Request;
use core\Response;
use helpers\Storage;

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


}