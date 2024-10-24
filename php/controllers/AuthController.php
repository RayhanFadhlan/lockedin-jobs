<?php

namespace controllers;

use exceptions\InternalServerErrorException;
use models\UserModel;
use models\CompanyModel;
use core\Request;
use core\Response;
use helpers\Redirect;
use exceptions\BadRequestException;

class AuthController extends Controller {
    protected $userModel;
    protected $companyModel;

    public function __construct() {
       
        $this->userModel = new UserModel();
        $this->companyModel = new CompanyModel();
    }

    public function viewRegister() {
        return $this->views('signup', ['css' => 'auth']);
    }

    public function viewLogin() {
        if(isset($_SESSION['user'])) {
            Redirect::to('/');
        }
        return $this->views('login', ['css' => 'auth']);
    }

    public function signout() {
        session_destroy();
        Redirect::withToast('/', 'Logout successful', 'success');
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
                    throw new BadRequestException('Email already exists');
                }
    
            
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                $user = $this->userModel->createUser($email, $name, $hashedPassword, $role);

                if (!$user) {
                    throw new InternalServerErrorException('Failed to create user');
                }

                $_SESSION['user'] = [
                    'id' => $user['user_id'],
                    'email' => $user['email'],
                    'name' => $user['nama'],
                    'role' => $user['role'],
                ];


                Redirect::withToast('/', 'User created successfully', 'success');

            }
            else if($role === 'company'){
                $companyName = $request->getBody('company_name');
                $companyEmail = $request->getBody('company_email');
                $location = $request->getBody('location');
                $about = $request->getBody('about');
                $password = $request->getBody('password');

                $request->validate( [
                    'company_name' => ['required', ['min', 5]],
                    'company_email' => ['required', 'email'],
                    'location' => ['required'],
                    'about' => ['required', ],
                    'password' => ['required', ['min', 8]],
                ]);
                if($this->userModel->checkEmailExists($companyEmail)) {
                    throw new BadRequestException('Email already exists');
                }
    
                // if($this->userModel->checkUsernameExists($companyName)) {
                //     throw new \Exception('Name already exists');
                // }

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $user = $this->userModel->createUser($companyEmail, $companyName, $hashedPassword, $role);

                if (!$user) {
                    throw new InternalServerErrorException('Failed to create user');
                }
                
                $this->companyModel->createCompany($user['user_id'], $location, $about);

                $_SESSION['user'] = [
                    'id' => $user['user_id'],
                    'email' => $user['email'],
                    'name' => $user['nama'],
                    'role' => $user['role'],
                ];

                Redirect::withToast('/', 'Company created successfully', 'success');
            }
           
                   
        
        } catch (\Exception $e) {
            return Redirect::withToast('/signup', $e->getMessage(), 'error');
        }
      
    }

    public function login(Request $request) {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', ['min', 8]]
            ]);

            $email = $request->getBody('email');
            $password = $request->getBody('password');

            $user = $this->userModel->checkEmailExists($email);

            if (!$user) {
                throw new BadRequestException('User not found');
            }

            if (!password_verify($password, $user['password'])) {
                throw new BadRequestException('Invalid password');
            }

            $_SESSION['user'] = [
                'id' => $user['user_id'],
                'email' => $user['email'],
                'name' => $user['nama'],
                'role' => $user['role'],
            ];

            Redirect::withToast('/', 'Login successful', 'success');

        } catch (\Exception $e) {
            return Redirect::withToast('/login', $e->getMessage(), 'error');
        }
    }

  
}