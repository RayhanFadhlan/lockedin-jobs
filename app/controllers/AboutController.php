<?php
namespace controllers;
use models\User;
use models\UserModel;

class AboutController extends Controller {
    public function index() {
        $data = [
            'catFact' => $this->getCatFact(),
            'users' => $this->getUsers()
        ];
        
        $this->views('about', $data);
    }

    private function getCatFact() {
        return "catto";
    }

    private function getUsers() {
        $user = new UserModel();
        return $user->all();
    }

    
}