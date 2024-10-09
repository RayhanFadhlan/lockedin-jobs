<?php
namespace controllers;
use models\User;

class AboutController {
    public function index() {
        $data = [
            'catFact' => $this->getCatFact(),
            'users' => $this->getUsers()
        ];
        
        extract($data);
        include VIEW_PATH . 'about.php';
    }

    private function getCatFact() {
        return "catto";
    }

    private function getUsers() {
        $user = new User();
        return $user->all();
    }

    
}