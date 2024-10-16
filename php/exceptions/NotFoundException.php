<?php

namespace exceptions;

class NotFoundException extends BaseException
{
    public function __construct($message = "Page Not Found")
    {
        parent::__construct($message, 404);
    }
}