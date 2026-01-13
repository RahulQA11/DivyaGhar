<?php
/**
 * Admin Logout
 * Divyaghar E-commerce Website
 */

require_once '../config/database.php';

// Destroy session
session_destroy();

setFlashMessage('success', 'You have been logged out successfully');
redirect('admin/login.php');
?>
