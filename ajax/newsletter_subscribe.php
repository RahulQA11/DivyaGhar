<?php
/**
 * AJAX Handler - Newsletter Subscribe
 * Divyaghar E-commerce Website
 */

require_once '../config/database.php';

header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get and validate email
$email = clean($_POST['email'] ?? '');

if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

if (!isValidEmail($email)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

// Check if email already exists
$existing = $db->fetch("SELECT id FROM newsletter_subscribers WHERE email = ?", [$email]);
if ($existing) {
    echo json_encode(['success' => false, 'message' => 'You are already subscribed']);
    exit;
}

// Add to database (create table if not exists)
try {
    $db->query("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id int(11) AUTO_INCREMENT PRIMARY KEY,
        email varchar(100) NOT NULL UNIQUE,
        status enum('active', 'inactive') DEFAULT 'active',
        created_at timestamp DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    $db->query("INSERT INTO newsletter_subscribers (email) VALUES (?)", [$email]);
    
    echo json_encode(['success' => true, 'message' => 'Thank you for subscribing!']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
}
?>
