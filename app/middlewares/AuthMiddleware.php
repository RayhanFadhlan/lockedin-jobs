<?php

namespace middlewares;
use middlewares\Middleware;
use helpers\Redirect;

class AuthMiddleware extends Middleware
{
    public function handle($request, $next)
    {
     
        if (!isset($_SESSION['user_id'])) {
            
            Redirect::to('/');
        }
        
        return $next($request);
    }
}