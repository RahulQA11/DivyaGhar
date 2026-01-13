<?php
/**
 * Rate Limiting Class
 * Divyaghar E-commerce Website
 */

class RateLimiter {
    private static $attempts = [];
    
    /**
     * Check if action is allowed
     */
    public static function allow($key, $limit, $window = 3600) {
        $now = time();
        $windowStart = $now - $window;
        
        // Clean old attempts
        if (isset(self::$attempts[$key])) {
            self::$attempts[$key] = array_filter(self::$attempts[$key], function($timestamp) use ($windowStart) {
                return $timestamp > $windowStart;
            });
        }
        
        // Check limit
        if (isset(self::$attempts[$key]) && count(self::$attempts[$key]) >= $limit) {
            return false;
        }
        
        // Record attempt
        if (!isset(self::$attempts[$key])) {
            self::$attempts[$key] = [];
        }
        self::$attempts[$key][] = $now;
        
        return true;
    }
    
    /**
     * Get remaining attempts
     */
    public static function remaining($key, $limit, $window = 3600) {
        $now = time();
        $windowStart = $now - $window;
        
        if (!isset(self::$attempts[$key])) {
            return $limit;
        }
        
        // Clean old attempts
        self::$attempts[$key] = array_filter(self::$attempts[$key], function($timestamp) use ($windowStart) {
            return $timestamp > $windowStart;
        });
        
        return max(0, $limit - count(self::$attempts[$key]));
    }
    
    /**
     * Get reset time
     */
    public static function resetTime($key, $window = 3600) {
        if (!isset(self::$attempts[$key]) || empty(self::$attempts[$key])) {
            return 0;
        }
        
        $oldestAttempt = min(self::$attempts[$key]);
        return $oldestAttempt + $window;
    }
}
?>
