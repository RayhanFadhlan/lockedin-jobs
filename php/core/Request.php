<?php

namespace core;
use Exception;
use exceptions\BadRequestException;
use services\ValidationService;
class Request {
    private $method;
    private $uri;
    private $params;

    private $validationService;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = strtok($_SERVER['REQUEST_URI'], '?');
        $this->uri = rtrim($this->uri, '/');
        $this->uri = empty($this->uri) ? '/' : $this->uri;
        $this->params = $_REQUEST;
        $this->validationService = new ValidationService();
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getParams() {
        return $this->params;
    }

    public function getBody($key) {
        return $this->params[$key] ?? null;
    }

    public function validate($rules)
    {
        if (!$this->validationService->validate($this->params, $rules)) {
            throw new BadRequestException( $this->validationService->getStringErrors());
        }
        return true;
    }
}