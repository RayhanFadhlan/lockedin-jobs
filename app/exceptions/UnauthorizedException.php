<?php

namespace exceptions;

class UnauthorizedException extends BaseException
{
    public function __construct($message = "Unauthorized Access")
    {
        parent::__construct($message, 401);
    }
}