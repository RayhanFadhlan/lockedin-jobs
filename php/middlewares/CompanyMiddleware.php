<?php

namespace middlewares;
use helpers\Redirect;


// protect routes so only company can access
class CompanyMiddleware extends Middleware
{
    public function handle($request, $next)
    {
        if (!isset($_SESSION['user'])) {
            Redirect::withToast('/', 'access forbidden');
        }
        if ($_SESSION['user']['role'] !== 'company') {
            Redirect::withToast('/', 'access forbidden');
        }
        return $next($request);
    }
}