<?php
/**
 * Complete Database Setup for Admin Panel
 * Divyaghar E-commerce Website
 */

require_once '../config/database.php';

echo "<h2>Setting up Divyaghar Admin Panel Database...</h2>";

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
    echo "✅ Settings table created successfully<br>";
} catch (Exception $e) {
    echo "❌ Error creating settings table: " . $e->getMessage() . "<br>";
}

// Update users table to include missing fields
$sql = "ALTER TABLE users 
ADD COLUMN IF NOT EXISTS first_name VARCHAR(100) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS last_name VARCHAR(100) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS phone VARCHAR(20) DEFAULT NULL";

try {
    $db->query($sql);
    echo "✅ Users table updated successfully<br>";
} catch (Exception $e) {
    echo "ℹ️ Users table already updated or error: " . $e->getMessage() . "<br>";
}

// Insert default settings
$default_settings = [
    'site_name' => 'Divyaghar',
    'site_description' => 'Premium spiritual items and home décor crafted for sacred living',
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
    'email_from_address' => 'info@divyaghar.com',
    'admin_products_per_page' => '10',
    'admin_categories_per_page' => '10',
    'admin_users_per_page' => '10',
    'admin_orders_per_page' => '10'
];

foreach ($default_settings as $key => $value) {
    $sql = "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";
    try {
        $db->query($sql, [$key, $value]);
    } catch (Exception $e) {
        echo "⚠️ Warning inserting setting $key: " . $e->getMessage() . "<br>";
    }
}

echo "✅ Default settings inserted successfully<br>";

// Check if admin user exists, if not create one
$admin_check = $db->fetch("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
if ($admin_check['count'] == 0) {
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password, role, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?)";
    try {
        $db->query($sql, ['admin', 'admin@divyaghar.com', $hashed_password, 'admin', 'Admin', 'User']);
        echo "✅ Default admin user created (admin/admin123)<br>";
    } catch (Exception $e) {
        echo "❌ Error creating admin user: " . $e->getMessage() . "<br>";
    }
} else {
    echo "ℹ️ Admin user already exists<br>";
}

// Create uploads directory if it doesn't exist
$upload_dirs = [
    '../uploads/products',
    '../uploads/categories',
    '../uploads/users',
    '../uploads/temp'
];

foreach ($upload_dirs as $dir) {
    if (!file_exists($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "✅ Created directory: $dir<br>";
        } else {
            echo "❌ Failed to create directory: $dir<br>";
        }
    } else {
        echo "ℹ️ Directory already exists: $dir<br>";
    }
}

// Create .htaccess for uploads directory
$htaccess_content = "Options -Indexes\n<FilesMatch '\.(php|phtml|php3|php4|php5|pl|py|cgi|sh|bat)$'>\n    Order Allow,Deny\n    Deny from all\n</FilesMatch>";
if (file_put_contents('../uploads/.htaccess', $htaccess_content)) {
    echo "✅ Created .htaccess for uploads directory<br>";
} else {
    echo "⚠️ Could not create .htaccess for uploads directory<br>";
}

echo "<h3>✅ Database setup complete!</h3>";
echo "<p><strong>Admin Login:</strong><br>";
echo "URL: <a href='../admin/login.php'>admin/login.php</a><br>";
echo "Username: admin<br>";
echo "Password: admin123</p>";
?>
