<?php

namespace middlewares;
use helpers\Redirect;


// protect routes so only company can access
class CompanyMiddleware extends Middleware
{
    public function handle($request, $next)
    {
        if (!isset($_SESSION['user'])) {
            Redirect::withToast('/', 'Only Job Seeker can access');
        }
        if ($_SESSION['user']['role'] !== 'jobseeker') {
            Redirect::withToast('/', 'Only Job Seeker can access');
        }
        return $next($request);
    }
}