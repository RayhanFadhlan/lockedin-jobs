<?php

namespace exceptions;

class InternalServerErrorException extends BaseException
{
    public function __construct($message = "Internal Server Error")
    {
        parent::__construct($message, 500);
    }
}