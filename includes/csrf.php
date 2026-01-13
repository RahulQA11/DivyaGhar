<?php
/**
 * CSRF Token Helper
 * Divyaghar E-commerce Website
 */

class CSRFToken {
    /**
     * Generate CSRF token
     */
    public static function generate() {
        if (!isset($_SESSION['csrf_tokens'])) {
            $_SESSION['csrf_tokens'] = [];
        }
        
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_tokens'][$token] = time();
        
        // Keep only last 10 tokens
        if (count($_SESSION['csrf_tokens']) > 10) {
            $_SESSION['csrf_tokens'] = array_slice($_SESSION['csrf_tokens'], -10, null, true);
        }
        
        return $token;
    }
    
    /**
     * Validate CSRF token
     */
    public static function validate($token) {
        if (!isset($_SESSION['csrf_tokens'][$token])) {
            return false;
        }
        
        // Check if token is not too old (1 hour)
        $tokenTime = $_SESSION['csrf_tokens'][$token];
        if (time() - $tokenTime > 3600) {
            unset($_SESSION['csrf_tokens'][$token]);
            return false;
        }
        
        // Remove used token
        unset($_SESSION['csrf_tokens'][$token]);
        return true;
    }
    
    /**
     * Get hidden input field HTML
     */
    public static function getField() {
        $token = self::generate();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
    
    /**
     * Clean old tokens
     */
    public static function clean() {
        if (!isset($_SESSION['csrf_tokens'])) {
            return;
        }
        
        $currentTime = time();
        foreach ($_SESSION['csrf_tokens'] as $token => $time) {
            if ($currentTime - $time > 3600) {
                unset($_SESSION['csrf_tokens'][$token]);
            }
        }
    }
}

// Auto-clean old tokens on each request
CSRFToken::clean();
?>
