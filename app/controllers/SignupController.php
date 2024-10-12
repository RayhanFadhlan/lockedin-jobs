<?php

namespace controllers;

use models\UserModel;

class SignupController extends Controller {
    protected $userModel;

    public function __construct() {
        $this->userModel = new UserModel(); 
    }

    public function index() {
        $this->views('signup');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (isset($data['field']) && isset($data['value'])) {
                $this->handleValidation($data['field'], $data['value']);
                return;
            }

            if (isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['role'])) {
                $this->handleFormSubmission();
            }
        }
    }

    private function handleValidation($field, $value) {
        if ($field === 'email') {
            if ($this->userModel->checkEmailExists($value)) {
                echo json_encode(['status' => 'error', 'message' => 'Email is already taken']);
            } else {
                echo json_encode(['status' => 'success']);
            }
        }

        if ($field === 'username') {
            if ($this->userModel->checkUsernameExists($value)) {
                echo json_encode(['status' => 'error', 'message' => 'Username is already taken']);
            } else {
                echo json_encode(['status' => 'success']);
            }
        }
    }

    private function handleFormSubmission() {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if ($this->userModel->checkEmailExists($email)) {
            $_SESSION['error'] = 'Email already exists';
            header('Location: /signup');
            exit;
        }

        if ($this->userModel->checkUsernameExists($username)) {
            $_SESSION['error'] = 'Username already exists';
            header('Location: /signup');
            exit;
        }

        if (empty($role)) {
            $_SESSION['error'] = 'Please select a role';
            header('Location: /signup');
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userCreated = $this->userModel->createUser($email, $username, $hashedPassword, $role);

        if ($userCreated) {
            header('Location: /?login');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to create user';
            header('Location: /signup');
            exit;
        }
    }
}
