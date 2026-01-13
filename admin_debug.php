<?php
/**
 * Admin User Debug Script
 * Check if admin user exists and debug login
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🔍 Admin User Debug - Divyaghar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255,255,255,0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 36px;
            margin: 0;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .debug-section {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #4CAF50;
        }
        .debug-section h3 {
            color: #4CAF50;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .debug-section p {
            color: #333;
            line-height: 1.6;
        }
        .code-block {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            border-left: 4px solid #007bff;
        }
        .status {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        .status-success {
            background: #d4ed31;
            color: #155724;
        }
        .status-error {
            background: #f8d7da;
            color: #721c24;
        }
        .status-warning {
            background: #fff3cd;
            color: #856404;
        }
        .btn {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin: 10px 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>🔍 Admin User Debug</h1>
            <p>Check admin user status and debug login</p>
        </div>";

// Check if admin user exists
$sql = "SELECT * FROM users WHERE role = 'admin'";
$admin_users = $db->fetchAll($sql);

echo "<div class='debug-section'>
    <h3>👥 Admin Users in Database</h3>";

if (count($admin_users) > 0) {
    echo "<p><strong>Found " . count($admin_users) . " admin user(s):</strong></p>";
    foreach ($admin_users as $user) {
        echo "<div class='code-block'>
            <strong>ID:</strong> " . $user['id'] . "<br>
            <strong>Username:</strong> " . $user['username'] . "<br>
            <strong>Email:</strong> " . $user['email'] . "<br>
            <strong>Role:</strong> " . $user['role'] . "<br>
            <strong>Created:</strong> " . $user['created_at'] . "<br>
            <strong>Password Hash:</strong> " . substr($user['password'], 0, 20) . "...
        </div>";
    }
} else {
    echo "<p><strong>No admin users found in database.</strong></p>";
}

echo "</div>";

// Test password verification
echo "<div class='debug-section'>
    <h3>🔐 Password Verification Test</h3>";

$test_password = 'admin123';
$test_username = 'admin';

$sql = "SELECT * FROM users WHERE username = ? AND role = 'admin'";
$test_user = $db->fetch($sql, [$test_username]);

if ($test_user) {
    echo "<p><strong>User found:</strong> " . $test_user['username'] . "</p>";
    
    // Test password verification
    if (password_verify($test_password, $test_user['password'])) {
        echo "<div class='status status-success'>
            <h4>✅ Password Verification SUCCESS!</h4>
            <p>Password 'admin123' matches the stored hash.</p>
        </div>";
    } else {
        echo "<div class='status status-error'>
            <h4>❌ Password Verification FAILED!</h4>
            <p>Password 'admin123' does not match the stored hash.</p>
        </div>";
    }
} else {
    echo "<p><strong>User 'admin' not found in database.</strong></p>";
}

echo "</div>";

// Check database connection
echo "<div class='debug-section'>
    <h3>🗄️ Database Connection Status</h3>
    <p><strong>Database Name:</strong> " . DB_NAME . "</p>
    <p><strong>Database Host:</strong> " . DB_HOST . "</p>
    <p><strong>Connection Status:</strong> " . ($db ? "Connected" : "Not Connected") . "</p>
</div>";

// Provide solution
echo "<div class='debug-section'>
    <h3>🔧 Solution</h3>";

if (count($admin_users) == 0) {
    echo "<div class='status status-warning'>
        <h4>⚠️ No Admin User Found</h4>
        <p>You need to create an admin user first.</p>
    </div>";
} else {
    echo "<div class='status status-success'>
        <h4>✅ Admin User Exists</h4>
        <p>If password verification failed, you may need to reset the password.</p>
    </div>";
}

echo "</div>";

echo "<div style='text-align: center; margin-top: 40px;'>
    <button class='btn' onclick='window.location.href=\"quick_admin.php\"'>🔧 Create/Reset Admin User</button>
    <button class='btn' onclick='window.location.href=\"admin/login.php\"'>🔐 Try Admin Login</button>
    <button class='btn btn-danger' onclick='window.location.href=\"index.php\"'>🏠 Back to Website</button>
</div>
</div>
</body>
</html>";
?>
