<?php
namespace core;
use core\Router;
class App
{
    public $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run()
    {
        
        $this->initSession();

        $uri = $this->getUri();
        $method = $_SERVER['REQUEST_METHOD'];
        $this->router->dispatch($uri, $method);
    }

    private function getUri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = strtok($uri, '?');
        $uri = rtrim($uri, '/');
        return empty($uri) ? '/' : $uri;
    }
    private function initSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            
            session_set_cookie_params([
                'lifetime' => 24 * 60 * 60,
                'path' => '/',
                'domain' => '',
                'secure' => true,   
                'httponly' => true, 
                'samesite' => 'Lax' 
            ]);
            
            session_start();
        }
    }
}