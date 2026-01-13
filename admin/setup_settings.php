<?php
/**
 * Create Settings Table
 * Divyaghar E-commerce Website
 */

require_once '../config/database.php';

// Create settings table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

try {
    $db->query($sql);
    echo "Settings table created successfully";
} catch (Exception $e) {
    echo "Error creating settings table: " . $e->getMessage();
}

// Insert default settings
$default_settings = [
    'site_name' => 'Divyaghar',
    'site_description' => 'Premium spiritual items and home décor',
    'site_email' => 'info@divyaghar.com',
    'site_phone' => '+91 98765 43210',
    'site_address' => '123 Temple Street, Mumbai, Maharashtra 400001',
    'currency' => 'INR',
    'tax_rate' => '18',
    'shipping_cost' => '50',
    'free_shipping_threshold' => '999',
    'cod_enabled' => '1',
    'cod_min_amount' => '0',
    'paypal_enabled' => '0',
    'paypal_email' => '',
    'stripe_enabled' => '0',
    'stripe_public_key' => '',
    'stripe_secret_key' => '',
    'smtp_host' => '',
    'smtp_port' => '587',
    'smtp_username' => '',
    'smtp_password' => '',
    'smtp_encryption' => 'tls',
    'email_from_name' => 'Divyaghar',
    'email_from_address' => 'info@divyaghar.com'
];

foreach ($default_settings as $key => $value) {
    $sql = "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";
    $db->query($sql, [$key, $value]);
}

echo "Default settings inserted successfully";
?>
