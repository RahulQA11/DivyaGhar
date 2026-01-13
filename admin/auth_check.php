<?php
/**
 * Admin Authentication Check
 * Divyaghar E-commerce Website
 */

require_once '../config/database.php';
require_once '../includes/functions.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    session_start();
    setFlashMessage('error', 'You must be logged in as admin to access this page');
    redirect('admin/login.php');
}

// Check session timeout
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > SESSION_LIFETIME)) {
    session_destroy();
    setFlashMessage('error', 'Session expired. Please login again');
    redirect('admin/login.php');
}

// Regenerate session ID for security
if (!isset($_SESSION['regenerated'])) {
    session_regenerate_id(true);
    $_SESSION['regenerated'] = true;
}
?>
