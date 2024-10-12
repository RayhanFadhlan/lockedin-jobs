<?php

namespace core;

class Request {
    private $method;
    private $uri;
    private $params;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = strtok($_SERVER['REQUEST_URI'], '?');
        $this->uri = rtrim($this->uri, '/');
        $this->uri = empty($this->uri) ? '/' : $this->uri;
        $this->params = $_REQUEST;
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
}