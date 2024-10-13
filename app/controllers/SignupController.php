<?php

namespace controllers;

use models\UserModel;
use models\CompanyModel;
use core\Request;
use core\Response;
use helpers\Redirect;

class SignupController extends Controller {
    protected $userModel;
    protected $companyModel;

    public function __construct() {
       
        $this->userModel = new UserModel();
        $this->companyModel = new CompanyModel();
    }

    public function index() {
        return $this->views('signup');
    }

    public function register(Request $request) {

        try {

            $role = $request->getBody('role');

            if ($role === 'jobseeker'){

                $request->validate([
                    'email' => ['required', 'email'],
                    'name' => ['required', ['min', 5]],
                    'password' => ['required', ['min', 8]],
                    'role' => ['required']
                ]);
                $email = $request->getBody('email');
                $name = $request->getBody('name');
                $password = $request->getBody('password');
    
                if($this->userModel->checkEmailExists($email)) {
                    throw new \Exception('Email already exists');
                }
    
                if($this->userModel->checkUsernameExists($name)) {
                    throw new \Exception('Name already exists');
                }
                
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                $this->userModel->createUser($email, $name, $hashedPassword, $role);

                Redirect::withToast('/', 'User created successfully');

            }
            else if($role === 'company'){
                $companyName = $request->getBody('company_name');
                $companyEmail = $request->getBody('company_email');
                $location = $request->getBody('location');
                $about = $request->getBody('about');
                $password = $request->getBody('password');

                $request->validate( [
                    'company_name' => ['required', 'min:3'],
                    'company_email' => ['required', 'email'],
                    'location' => ['required'],
                    'about' => ['required', 'min:10'],
                    'password' => ['required', 'min:8']
                ]);
                if($this->userModel->checkEmailExists($companyEmail)) {
                    throw new \Exception('Email already exists');
                }
    
                if($this->userModel->checkUsernameExists($companyName)) {
                    throw new \Exception('Name already exists');
                }

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $userId = $this->userModel->createUser($companyEmail, $companyName, $hashedPassword, $role);

                if (!$userId) {
                    throw new \Exception('Failed to create user');
                }
                
                $this->companyModel->createCompany($userId, $location, $about);

                Redirect::withToast('/', 'Company created successfully');
            }
           
            
                   
        
        } catch (\Exception $e) {
            return Redirect::withToast('/signup', $e->getMessage());
        }
      
    }

  
}