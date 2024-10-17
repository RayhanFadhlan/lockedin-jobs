<?php
namespace controllers;

use exceptions\UnauthorizedException;
use models\LamaranModel;
use helpers\Redirect;
use core\Request;

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
}