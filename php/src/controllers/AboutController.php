<?php
namespace controllers;
use models\User;

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
        $user = new User();
        return $user->all();
    }

    
}