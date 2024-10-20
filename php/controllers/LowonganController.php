<?php
namespace controllers;

use exceptions\UnauthorizedException;
use models\LamaranModel;
use models\LowonganModel;
use models\CompanyModel;
use helpers\Redirect;

class LowonganController extends Controller {
    protected $lamaranModel;
    protected $lowonganModel;
    protected $companyModel;

    public function __construct() {
        $this->lamaranModel = new LamaranModel();
        $this->lowonganModel = new LowonganModel();
        $this->companyModel = new CompanyModel();
    }

    public function viewDetailLowongan() {
        $this->views('detail-lowongan');
    }
    public function getDetailLowongan($request, $lowongan_id) {
        try {
            $userId = 1;

            $lowongan = $this->lowonganModel->getLowonganById( $lowongan_id );
            $lamaran = $this->lamaranModel->getLamaranByUserId( $userId, $lowongan_id );
            $company = $this->companyModel->getCompany($lowongan[0]['company_id']);

            header('Content-Type: application/json');
            echo json_encode([
                'lamaran' => $lamaran,
                'lowongan' => $lowongan,
                'company' => $company,
            ]);
        } catch (\Exception $e) {
            return Redirect::withToast('/login', $e->getMessage());
        }
    }
}