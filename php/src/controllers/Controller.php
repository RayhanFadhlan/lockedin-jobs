<?php
namespace controllers;
class Controller {
    public function views($view, $data = []) {
        extract($data);
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new \Exception("View file not found: " . $viewPath);
        }
    }
}