<?php
/**
 * Database Configuration File
 * Divyaghar E-commerce Website
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'divyaghar_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('SITE_URL', 'http://localhost/DivyaGhar/');
define('SITE_NAME', 'Divyaghar');
define('SITE_EMAIL', 'info@divyaghar.com');
define('ADMIN_EMAIL', 'admin@divyaghar.com');

// Paths
define('ROOT_PATH', __DIR__ . '/..');
define('UPLOAD_PATH', ROOT_PATH . '/uploads/');
define('ASSETS_PATH', ROOT_PATH . '/assets/');

// Security
define('HASH_COST', 12);
define('SESSION_LIFETIME', 3600); // 1 hour

// Pagination
define('PRODUCTS_PER_PAGE', 12);
define('ADMIN_PRODUCTS_PER_PAGE', 10);

// Image upload settings
define('MAX_IMAGE_SIZE', 5242880); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/connection.php';

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Include functions file
require_once __DIR__ . '/../includes/functions.php';
?>
