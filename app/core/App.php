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
        session_start();

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
}