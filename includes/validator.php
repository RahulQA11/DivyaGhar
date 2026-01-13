<?php
/**
 * Input Validation Class
 * Divyaghar E-commerce Website
 */

class Validator {
    private $errors = [];
    private $data;
    
    public function __construct($data = []) {
        $this->data = $data;
    }
    
    /**
     * Validate required field
     */
    public function required($field, $message = null) {
        if (!isset($this->data[$field]) || empty(trim($this->data[$field]))) {
            $this->errors[$field] = $message ?? ucfirst($field) . ' is required';
        }
        return $this;
    }
    
    /**
     * Validate email
     */
    public function email($field, $message = null) {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                $this->errors[$field] = $message ?? 'Please enter a valid email address';
            }
        }
        return $this;
    }
    
    /**
     * Validate phone number (Indian format)
     */
    public function phone($field, $message = null) {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            $phone = preg_replace('/[^0-9]/', '', $this->data[$field]);
            if (!preg_match('/^[6-9][0-9]{9}$/', $phone)) {
                $this->errors[$field] = $message ?? 'Please enter a valid 10-digit phone number';
            }
        }
        return $this;
    }
    
    /**
     * Validate minimum length
     */
    public function minLength($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen(trim($this->data[$field])) < $length) {
            $this->errors[$field] = $message ?? ucfirst($field) . ' must be at least ' . $length . ' characters';
        }
        return $this;
    }
    
    /**
     * Validate maximum length
     */
    public function maxLength($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen(trim($this->data[$field])) > $length) {
            $this->errors[$field] = $message ?? ucfirst($field) . ' must not exceed ' . $length . ' characters';
        }
        return $this;
    }
    
    /**
     * Validate numeric value
     */
    public function numeric($field, $message = null) {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!is_numeric($this->data[$field])) {
                $this->errors[$field] = $message ?? ucfirst($field) . ' must be a number';
            }
        }
        return $this;
    }
    
    /**
     * Validate positive number
     */
    public function positive($field, $message = null) {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!is_numeric($this->data[$field]) || $this->data[$field] <= 0) {
                $this->errors[$field] = $message ?? ucfirst($field) . ' must be a positive number';
            }
        }
        return $this;
    }
    
    /**
     * Validate integer
     */
    public function integer($field, $message = null) {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_INT)) {
                $this->errors[$field] = $message ?? ucfirst($field) . ' must be an integer';
            }
        }
        return $this;
    }
    
    /**
     * Validate minimum value
     */
    public function min($field, $min, $message = null) {
        if (isset($this->data[$field]) && is_numeric($this->data[$field])) {
            if ($this->data[$field] < $min) {
                $this->errors[$field] = $message ?? ucfirst($field) . ' must be at least ' . $min;
            }
        }
        return $this;
    }
    
    /**
     * Validate maximum value
     */
    public function max($field, $max, $message = null) {
        if (isset($this->data[$field]) && is_numeric($this->data[$field])) {
            if ($this->data[$field] > $max) {
                $this->errors[$field] = $message ?? ucfirst($field) . ' must not exceed ' . $max;
            }
        }
        return $this;
    }
    
    /**
     * Validate pattern (regex)
     */
    public function pattern($field, $pattern, $message = null) {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!preg_match($pattern, $this->data[$field])) {
                $this->errors[$field] = $message ?? ucfirst($field) . ' format is invalid';
            }
        }
        return $this;
    }
    
    /**
     * Validate alphanumeric
     */
    public function alphanumeric($field, $message = null) {
        return $this->pattern($field, '/^[a-zA-Z0-9]+$/', $message);
    }
    
    /**
     * Validate alpha (letters only)
     */
    public function alpha($field, $message = null) {
        return $this->pattern($field, '/^[a-zA-Z]+$/', $message);
    }
    
    /**
     * Validate URL
     */
    public function url($field, $message = null) {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_URL)) {
                $this->errors[$field] = $message ?? 'Please enter a valid URL';
            }
        }
        return $this;
    }
    
    /**
     * Validate price format
     */
    public function price($field, $message = null) {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            $price = $this->data[$field];
            if (!is_numeric($price) || $price < 0 || $price > 999999.99) {
                $this->errors[$field] = $message ?? 'Please enter a valid price';
            }
        }
        return $this;
    }
    
    /**
     * Validate slug format
     */
    public function slug($field, $message = null) {
        return $this->pattern($field, '/^[a-z0-9-]+$/', $message);
    }
    
    /**
     * Custom validation callback
     */
    public function custom($field, $callback, $message = null) {
        if (isset($this->data[$field])) {
            if (!$callback($this->data[$field], $this->data)) {
                $this->errors[$field] = $message ?? ucfirst($field) . ' is invalid';
            }
        }
        return $this;
    }
    
    /**
     * Check if validation passes
     */
    public function passes() {
        return empty($this->errors);
    }
    
    /**
     * Check if validation fails
     */
    public function fails() {
        return !empty($this->errors);
    }
    
    /**
     * Get all errors
     */
    public function errors() {
        return $this->errors;
    }
    
    /**
     * Get first error
     */
    public function firstError($field = null) {
        if ($field) {
            return $this->errors[$field] ?? null;
        }
        
        return reset($this->errors) ?: null;
    }
    
    /**
     * Get all errors as string
     */
    public function errorsAsString($separator = '<br>') {
        return implode($separator, $this->errors);
    }
    
    /**
     * Sanitize input data
     */
    public function sanitize() {
        foreach ($this->data as $key => $value) {
            if (is_string($value)) {
                $this->data[$key] = trim($value);
            }
        }
        return $this;
    }
    
    /**
     * Get sanitized data
     */
    public function getData() {
        return $this->data;
    }
    
    /**
     * Validate CSRF token
     */
    public function csrf($field = 'csrf_token', $message = null) {
        if (!isset($this->data[$field]) || !CSRFToken::validate($this->data[$field])) {
            $this->errors[$field] = $message ?? 'Invalid security token. Please refresh the page and try again.';
        }
        return $this;
    }
}
?>
