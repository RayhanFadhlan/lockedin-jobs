<?php
namespace controllers;

class HomeController extends Controller {
    public function index() {
        $this->views('home');
    }
}