<?php
/**
 * Quick Admin User Setup
 * Divyaghar E-commerce Website
 */

require_once '../config/database.php';

echo "<h2>Setting up Admin User...</h2>";

// Check if admin user exists
$admin_check = $db->fetch("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
echo "<p>Admin users found: " . $admin_check['count'] . "</p>";

if ($admin_check['count'] == 0) {
    echo "<p>Creating admin user...</p>";
    
    // Insert admin user
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password, role, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?)";
    
    try {
        $db->query($sql, ['admin', 'admin@divyaghar.com', $hashed_password, 'admin', 'Admin', 'User']);
        echo "<p class='success'>✅ Admin user created successfully!</p>";
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error creating admin user: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='info'>ℹ️ Admin user already exists</p>";
    
    // Show existing admin users
    $admins = $db->fetchAll("SELECT username, email, created_at FROM users WHERE role = 'admin'");
    echo "<h3>Existing Admin Users:</h3>";
    foreach ($admins as $admin) {
        echo "<p>- Username: " . htmlspecialchars($admin['username']) . " | Email: " . htmlspecialchars($admin['email']) . " | Created: " . $admin['created_at'] . "</p>";
    }
}

// Test database connection
try {
    $test = $db->fetchAll("SELECT COUNT(*) as count FROM products");
    echo "<p class='success'>✅ Database connection successful!</p>";
    echo "<p>Products in database: " . $test[0]['count'] . "</p>";
} catch (Exception $e) {
    echo "<p class='error'>❌ Database connection failed: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li><a href='login_simple.php'>Login with Simple Admin</a> (admin/admin123)</li>";
echo "<li><a href='dashboard.php'>Go to Dashboard</a></li>";
echo "<li><a href='../'>Visit Main Website</a></li>";
echo "</ol>";

echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; }";
echo ".success { color: green; font-weight: bold; }";
echo ".error { color: red; font-weight: bold; }";
echo ".info { color: blue; font-weight: bold; }";
echo "h3 { color: #B8860B; margin-top: 20px; }";
echo "ol { line-height: 1.8; }";
echo "</style>";
?>
