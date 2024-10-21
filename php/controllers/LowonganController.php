<?php
namespace controllers;


use models\CompanyModel;
use models\LamaranModel;
use models\LowonganModel;
use models\UserModel;
use helpers\Redirect;

class LowonganController extends Controller {
    protected $lamaranModel;
    protected $lowonganModel;
    protected $userModel;
    protected $companyModel;

    public function __construct() {
        $this->lamaranModel = new LamaranModel();
        $this->lowonganModel = new LowonganModel();
        $this->userModel = new UserModel();
        $this->companyModel = new CompanyModel();
    }

    public function getDetailLowongan($request, $lowongan_id) {
        try {
            $lowongan = $this->lowonganModel->getLowonganById( $lowongan_id );
            $attachment = $this->lowonganModel->getAttachments($lowongan_id);
            if (isset($_SESSION['user'])) {
                $userId = $_SESSION['user']['id'];
                $lamaran = $this->lamaranModel->getLamaranByUserId( $userId, $lowongan_id );
            } else {
                $lamaran = null;
            }
            $company = $this->userModel->find($lowongan['company_id']) + $this->companyModel->getCompany($lowongan['company_id']);

            $data_lamaran = [
                'lamaran_id' => null,
                'status' => null,
                'status_reason' => null,
                'cv_path' => null,
                'video_path' => null,
            ];
            if ($lamaran != null) {
                $data_lamaran = [
                    'lamaran_id' => $lamaran['lamaran_id'],
                    'status' => $lamaran['status'],
                    'status_reason' => $lamaran['status_reason'],
                    'cv_path' => $lamaran['cv_path'],
                    'video_path' => $lamaran['video_path'],
                ];
            }
            $data = $data_lamaran + [
                'attachments' => $attachment,
                'lokasi' => $company['lokasi'],
                'about' => $company['about'],
                'lowongan_id' => $lowongan['lowongan_id'],
                'nama_company' => $company['nama'],
                'posisi' => $lowongan['posisi'],
                'deskripsi' => $lowongan['deskripsi'],
                'jenis_pekerjaan' => $lowongan['jenis_pekerjaan'],
                'jenis_lokasi' => $lowongan['jenis_lokasi'],
                'is_open' => $lowongan['is_open'],
                'created_at' => $lowongan['created_at'],
                'is_login' => isset($_SESSION['user']),
            ];

            return $this->views('detail-lowongan', $data);
        } catch (\Exception $e) {
            return Redirect::withToast('/login', $e->getMessage());
        }
    }
}