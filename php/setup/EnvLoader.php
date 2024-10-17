<?php

namespace setup;

class EnvLoader
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function load()
    {
        if (!file_exists($this->path)) {
            throw new \InvalidArgumentException("Environment file not found: {$this->path}");
        }

        if (!is_readable($this->path)) {
            throw new \RuntimeException("File {$this->path} is not readable");
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    }
}
