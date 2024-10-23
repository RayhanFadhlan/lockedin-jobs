<?php

namespace controllers;

use models\CompanyProfileModel;
use models\UserModel;
use core\Request;
use helpers\Redirect;

class CompanyProfileController extends Controller {
    protected $companyProfileModel;
    protected $userModel;

    public function __construct() {
        $this->companyProfileModel = new CompanyProfileModel();
        $this->userModel = new UserModel();
    }

    public function viewCompanyProfile() {
        $userId = $_SESSION['user']['id'];
        $this->views('profile', [
            'name' => $this->companyProfileModel->getCompanyNama($userId),
            'detail' => $this->companyProfileModel->getCompanyDetail($userId)
        ]);
    }

    public function viewCompanyProfileEdit() {
        $userId = $_SESSION['user']['id'];
        $this->views('profile-edit', [
            'name' => $this->companyProfileModel->getCompanyNama($userId),
            'detail' => $this->companyProfileModel->getCompanyDetail($userId)
        ]);
    }

    public function editCompanyProfile(Request $request) {
        try {
            $request->validate([
                'company_name' => ['required', ['min', 5]],
                'location' => ['required'],
                'about' => ['required', ],
            ]);

            $userId = $userId = $_SESSION['user']['id'];
            $companyName = $request->getBody('company_name');
            $location = $request->getBody('location');
            $about = $request->getBody('about');

            if($this->userModel->checkUsernameExists($companyName)) {
                throw new \Exception('Name already exists');
            }

            $this->companyProfileModel->setCompanyProfile($userId, $companyName, $location, $about);
            $_SESSION['user']['name'] = $request->getBody('company_name');

            Redirect::withToast('/profile', 'Company edited successfully', 'success');
        } catch (\Exception $e) {
            return Redirect::withToast('/profile', $e->getMessage(), 'error');
        }
    }

}