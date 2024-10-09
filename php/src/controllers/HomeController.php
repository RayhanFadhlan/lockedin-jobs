<?php
namespace controllers;

class HomeController {
    public function index() {
        include __DIR__ . '/../resources/views/home.php';
    }
}