<?php

require __DIR__ . '/../models/User.php';

class AboutController {
    public function index() {
        $data = [
            'catFact' => $this->getCatFact(),
            'users' => $this->getUsers()
        ];
        
        $this->render( $data);
    }

    private function getCatFact() {
        return "catto";
    }

    private function getUsers() {
        $user = new User();
        return $user->all();
    }

    private function render($data) {
        extract($data);
        include __DIR__ . '/../resources/views/about.php';
    }
}