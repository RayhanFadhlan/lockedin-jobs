<?php
namespace controllers;


use helpers\HTMLSanitizer;
use models\CompanyModel;
use models\LamaranModel;
use models\LowonganModel;
use models\UserModel;
use helpers\Redirect;
use core\Request;

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

    public function getDetailLowongan(Request $request, $lowongan_id) {
        try {
            $lowongan = $this->lowonganModel->getLowonganById( $lowongan_id );
            $attachments = $this->lowonganModel->getAttachments($lowongan_id);
            
            $lamaran = null;
            if (isset($_SESSION['user'])) {
                $userId = $_SESSION['user']['id'];
                $lamaran = $this->lamaranModel->getLamaranByUserId( $userId, $lowongan_id );
            }


            $company = $this->userModel->find($lowongan['company_id']) + $this->companyModel->getCompany($lowongan['company_id']);

            $imgPaths = array_map(function($attachment) {
                return '/' .  $attachment['file_path'];
            }, $attachments);

            $data_lamaran = [
            ];
            
            $isLamaran = $lamaran != null;
            $createdAt = new \DateTime($lowongan['created_at']);
            $formattedCreatedAt = $createdAt->format('F j, Y, g:i a');
            if ($lamaran != null) {
                $data_lamaran = [
                    'lamaran_id' => $lamaran['lamaran_id'],
                    'status' => $lamaran['status'],
                    'status_reason' => $lamaran['status_reason'],
                    'cv_path' => $lamaran['cv_path'],
                    'video_path' => $lamaran['video_path'],
                    // 'created_at' => $formattedCreatedAt,
                ];
            }

            $htmlSanitizer = new HTMLSanitizer();
            $data = $data_lamaran + [
                'images' => $imgPaths,
                'lokasi' => $company['lokasi'],
                'about' => $company['about'],
                'lowongan_id' => $lowongan['lowongan_id'],
                'nama_company' => $company['nama'],
                'posisi' => $lowongan['posisi'],
                'created_at' => $formattedCreatedAt,
                'deskripsi' => $htmlSanitizer->sanitize($lowongan['deskripsi']),
                'jenis_pekerjaan' => $lowongan['jenis_pekerjaan'],
                'jenis_lokasi' => $lowongan['jenis_lokasi'],
                'is_open' => $lowongan['is_open'],
                'is_login' => isset($_SESSION['user']),
                'is_lamaran' => $isLamaran,
            ];
            return $this->views('detail-lowongan', $data);
        } catch (\Exception $e) {
            return Redirect::withToast('/login', $e->getMessage());
        }
    }
}