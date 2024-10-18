<?php

namespace controllers;

use models\CompanyProfileModel;
use core\Request;
use helpers\Redirect;

class CompanyProfileController extends Controller {
    protected $companyProfileModel;

    public function __construct() {
        $this->companyProfileModel = new CompanyProfileModel();
    }

    public function viewCompanyProfile() {
        $userId = $_SESSION['user']['id'];
        $this->views('company/company-profile', [
            'css' => 'company-profile',
            'name' => $this->companyProfileModel->getCompanyNama($userId),
            'detail' => $this->companyProfileModel->getCompanyDetail($userId)
        ]);

        
    }

}