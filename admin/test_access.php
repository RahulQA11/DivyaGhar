<?php
/**
 * Test Admin Access
 * Divyaghar E-commerce Website
 */

session_start();

echo "<h1>🧪 Admin Access Test</h1>";

// Test 1: Check if auth_check functions work
echo "<h2>1. Testing auth_check.php functions</h2>";
require_once 'auth_check.php';

echo "<p style='color: green;'>✅ auth_check.php loaded successfully</p>";

// Test 2: Manual session test
echo "<h2>2. Manual Session Test</h2>";
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['user_role'] = 'admin';
$_SESSION['login_time'] = time();
$_SESSION['admin_logged_in'] = true;

echo "<p style='color: green;'>✅ Session set manually</p>";
echo "<p>User ID: " . $_SESSION['user_id'] . "</p>";
echo "<p>Username: " . $_SESSION['username'] . "</p>";
echo "<p>Role: " . $_SESSION['user_role'] . "</p>";

// Test 3: Check if we can access dashboard
echo "<h2>3. Dashboard Access Test</h2>";
echo "<p><a href='dashboard.php' style='background: #B8860B; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📊 Test Dashboard Access</a></p>";

// Test 4: Show current session
echo "<h2>4. Current Session Data</h2>";
echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
print_r($_SESSION);
echo "</pre>";

echo "<hr>";
echo "<h2>🚀 Quick Links</h2>";
echo "<p><a href='dashboard.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>📊 Go to Dashboard</a></p>";
echo "<p><a href='products.php' style='background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🛍️ Manage Products</a></p>";
echo "<p><a href='categories.php' style='background: #ffc107; color: black; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>📂 Manage Categories</a></p>";
echo "<p><a href='users.php' style='background: #6f42c1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>👥 Manage Users</a></p>";
echo "<p><a href='../' style='background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🏠 Visit Website</a></p>";

echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; }";
echo "h1 { color: #B8860B; }";
echo "h2 { color: #8B4513; margin-top: 30px; }";
echo "pre { background: #f8f9fa; padding: 15px; border-radius: 8px; }";
echo "</style>";
?>
