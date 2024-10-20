<?php
namespace controllers;

use exceptions\UnauthorizedException;
use models\LamaranModel;
use models\LowonganModel;
use models\UserModel;
use helpers\Redirect;

class LowonganController extends Controller {
    protected $lamaranModel;
    protected $lowonganModel;
    protected $userModel;

    public function __construct() {
        $this->lamaranModel = new LamaranModel();
        $this->lowonganModel = new LowonganModel();
        $this->userModel = new UserModel();
    }

    public function viewDetailLowongan() {
        $this->views('detail-lowongan');
    }
    public function getDetailLowongan($request, $lowongan_id) {
        try {
            $userId = 1;

            $lowongan = $this->lowonganModel->getLowonganById( $lowongan_id );
            $lamaran = $this->lamaranModel->getLamaranByUserId( $userId, $lowongan_id );
            $company = $this->userModel->find($lowongan['company_id']);

            $data = [
                'lamaran_id' => $lamaran['lamaran_id'],
                'nama_company' => $company['nama'],
                'posisi' => $lowongan['posisi'],
                'deskripsi' => $lowongan['deskripsi'],
                'jenis_pekerjaan' => $lowongan['jenis_pekerjaan'],
                'jenis_lokasi' => $lowongan['jenis_lokasi'],
                'is_open' => $lowongan['is_open'],
                'created_at' => $lowongan['created_at'],
            ];

            return $this->views('detail-lowongan', $data);
        } catch (\Exception $e) {
            return Redirect::withToast('/login', $e->getMessage());
        }
    }
}