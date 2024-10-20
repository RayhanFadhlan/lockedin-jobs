<?php
namespace controllers;

class Controller {
    
    public function views($view, $data = []) {

        // if(isset($_SESSION['toastMessage'])) {
        //     $data['toastMessage'] = $_SESSION['toastMessage'];        
        //     unset($_SESSION['toastMessage']);
        // }
        if(isset($data['toastMessage'])) {
            setcookie('toastMessage', $data['toastMessage'], time() + 60, '/');
        }

        $content = $this->renderView($view, $data);
        $this->renderLayout($content, $view, $data);
    }

    protected function renderView($view, $data = []) {
        extract($data);
        ob_start();
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new \Exception("View file not found: " . $viewPath);
        }
        return ob_get_clean();
    }

    protected function renderLayout($content, $view, $data = []) {
        extract($data);
        $layoutPath = __DIR__ . '/../views/layout/layout.php';
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            throw new \Exception("Layout file not found: " . $layoutPath);
        }
    }
}