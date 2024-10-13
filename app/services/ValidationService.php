<?php

namespace services;

class ValidationService extends Service {
    private $errors = [];

    public function validate($data, $rules)
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            if (!isset($data[$field])) {
                $data[$field] = null;
            }
            foreach ($fieldRules as $rule) {
                $this->applyRule($field, $data[$field], $rule);
            }
        }

        return empty($this->errors);
    }

    private function applyRule($field, $value, $rule)
    {
        if (is_string($rule)) {
            switch ($rule) {
                case 'required':
                    $this->validateRequired($field, $value);
                    break;
                case 'email':
                    $this->validateEmail($field, $value);
                    break;
            }
        } elseif (is_array($rule)) {
            switch ($rule[0]) {
                case 'min':
                    $this->validateMin($field, $value, $rule[1]);
                    break;
            }
        }
    }

    private function validateRequired($field, $value)
    {
        if (empty($value)) {
            $this->addError($field, "The {$field} field is required.");
        }
    }

    private function validateEmail($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "The {$field} must be a valid email address.");
        }
    }

    private function validateMin($field, $value, $min)
    {
        if (strlen($value) < $min) {
            $this->addError($field, "The {$field} must be at least {$min} characters.");
        }
    }

    private function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getStringErrors(){
        $errors = '';
        foreach ($this->errors as $field => $fieldErrors) {
            foreach ($fieldErrors as $error) {
                $errors .= $error . ' ';
            }
        }
        return $errors;
    }
}