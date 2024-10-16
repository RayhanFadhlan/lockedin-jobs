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
        return $this->views('history', ['css' => 'auth']);
    }

    public function getLamaran(Request $request) {
        try {
            $userId = $request->getBody('user_id') ?? -999;
            if ($userId === -999) {return new UnauthorizedException('Login untuk melihat riwayat lamaran');}

            $search = $request->getBody('search') ?? '';
            $status = isset($_GET['status']) ? explode(',', $_GET['status']) : [];
            $sort = $request->getBody('sort') ?? 'asc';
            $page = max(1, intval($request->getBody('page') ?? 1));

            $offset = ($page - 1) * $this->itemsPerPage;
            $lamaranList = $this->lamaranModel->getFilteredLamaran($userId, $search, $status, $sort, $offset);
            $totalLamaran = $this->lamaranModel->getTotalFilteredLamaran($userId, $search, $status);
            
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