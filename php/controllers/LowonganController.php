<?php
namespace controllers;

use models\LowonganModel;
use core\Request;

class LowonganController extends Controller
{
    protected $lowonganModel;

    public function __construct() {
        $this->lowonganModel = new LowonganModel();
    }

    public function index(Request $request)
    {
        // Mengambil ID lowongan dari URI
        $lowonganId = $request->getBody('id'); // Jika ID dikirim dalam body request
        // Atau jika lowonganId ada di URL
        // $lowonganId = $request->getParams()['id']; // Jika menggunakan parameter dari URL
        
        // Jika tidak ada ID, tampilkan pesan error
        if (!$lowonganId) {
            return $this->views('error', ['message' => 'Job ID is missing']);
        }

        $lowongan = $this->lowonganModel->getLowonganById($lowonganId);
        if (!$lowongan) {
            return $this->views('error', ['message' => 'Job not found']);
        }

        $userId = $_SESSION['user_id'] ?? null; // Ambil user_id dari session
        $lamaran = null;

        // Jika user login, cek apakah user sudah melamar lowongan ini
        if ($userId) {
            $lamaran = $this->lowonganModel->getLamaranByJobSeeker($userId, $lowonganId);
        }

        // Kirimkan data lowongan dan lamaran (jika ada) ke view
        return $this->views('detail-lowongan', [
            'lowongan' => $lowongan,
            'lamaran' => $lamaran
        ]);
    }

}