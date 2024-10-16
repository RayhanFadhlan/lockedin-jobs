<?php
namespace middlewares;
abstract class Middleware
{
    abstract public function handle($request, $next);
}