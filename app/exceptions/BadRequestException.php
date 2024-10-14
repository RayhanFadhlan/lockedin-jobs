<?php

namespace exceptions;

class BadRequestException extends BaseException
{
    public function __construct($message = "Bad Request")
    {
        parent::__construct($message, 400);
    }
}