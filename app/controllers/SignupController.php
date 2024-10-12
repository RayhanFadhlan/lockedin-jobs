<?php

namespace controllers;

use models\UserModel;
use core\Request;
use core\Response;
use helpers\Redirect;

class SignupController extends Controller {
    protected $userModel;

    public function __construct() {
       
        $this->userModel = new UserModel();
    }

    public function index() {
        return $this->views('signup');
    }

    public function register(Request $request) {
      
            $email = $request->getBody('email');
            $username = $request->getBody('username');
            $password = $request->getBody('password');
            $role = $request->getBody('role');

            // Server-side validation
            $errors = $this->validateInput($email, $username, $password, $role);

            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $userCreated = $this->userModel->createUser($email, $username, $hashedPassword, $role);

                if ($userCreated) {
                    return Redirect::to('/login')->with('success', 'Account created successfully. Please log in.');
                } else {
                    $errors[] = 'Failed to create user. Please try again.';
                }
            }

            // If there are errors, re-render the form with error messages
            return $this->views('signup');
        

      
    }

    private function validateInput($email, $username, $password, $role) {
        $errors = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        if ($this->userModel->checkEmailExists($email)) {
            $errors[] = 'Email already exists';
        }

        if (strlen($username) < 5) {
            $errors[] = 'Username must be at least 5 characters long';
        }

        if ($this->userModel->checkUsernameExists($username)) {
            $errors[] = 'Username already exists';
        }

        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long';
        }

        if (empty($role)) {
            $errors[] = 'Please select a role';
        }

        return $errors;
    }
}