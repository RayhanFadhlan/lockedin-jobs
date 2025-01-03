<?php
namespace core;
use Exception;
use core\Request;
use helpers\Redirect;
class Router
{
    private $routes = [];

    public function get($uri, $handler, $middleware = [])
    {
        $this->addRoute('GET', $uri, $handler, $middleware);
        return $this;
    }

    public function post($uri, $handler, $middleware = [])
    {
        $this->addRoute('POST', $uri, $handler, $middleware);
        return $this;
    }

    public function put($uri, $handler, $middleware = [])
    {
        $this->addRoute('PUT', $uri, $handler, $middleware);
        return $this;
    }

    public function delete($uri, $handler, $middleware = [])
    {
        $this->addRoute('DELETE', $uri, $handler, $middleware);
        return $this;
    }

    public function patch($uri, $handler, $middleware = [])
    {
        $this->addRoute('PATCH', $uri, $handler, $middleware);
        return $this;
    }
    

    private function addRoute($method, $uri, $handler, $middleware)
    {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function dispatch($uri, $method)
    {
        $request = new Request(); // Create a new Request object

        foreach ($this->routes as $route) {
            $pattern = $this->getPatternFromUri($route['uri']);
            if (preg_match($pattern, $uri, $params) && $route['method'] === $method) {
                array_shift($params); 
                foreach ($route['middleware'] as $middleware) {
                    $middlewareInstance = $this->resolveMiddleware($middleware);
                    $result = $middlewareInstance->handle($request, function(){});
                    if ($result !== null) {
                        return $result;
                    }
                }
                
                return $this->callHandler($route['handler'], array_merge([$request], $params));
            }
        }

        // header("HTTP/1.0 404 Not Found");
        // echo "404 Not Found";
        Redirect::to('/notfound');
    }

    private function getPatternFromUri($uri)
    {
        return '@^' . preg_replace('/:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_\.]+)', $uri) . '$@D';
    }

    private function callHandler($handler, $params)
    {
        if (is_array($handler)) {
            $controller = $this->resolveController($handler[0]);
            $method = $handler[1];
            return call_user_func_array([$controller, $method], $params);
        }
        return call_user_func_array($handler, $params);
    }

    private function resolveController($controller)
    {
        $controllerClass = "controllers\\{$controller}";
        if (!class_exists($controllerClass)) {
            throw new Exception("Controller {$controllerClass} not found");
        }
        return new $controllerClass();
    }

    private function resolveMiddleware($middleware)
    {
        $middlewareClass = "middlewares\\{$middleware}";
        if (!class_exists($middlewareClass)) {
            throw new Exception("Middleware {$middlewareClass} not found");
        }
        return new $middlewareClass();
    }
}