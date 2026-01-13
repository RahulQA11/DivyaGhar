<?php
/**
 * Password Fix Script
 * Fix admin user password verification
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🔧 Password Fix - Divyaghar</title>
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
        .test-section {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #4CAF50;
        }
        .test-section h3 {
            color: #4CAF50;
            margin-bottom: 15px;
            font-size: 18px;
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
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>🔧 Password Fix</h1>
            <p>Fix admin user password verification</p>
        </div>";

// Test admin2 user login
echo "<div class='test-section'>
    <h3>🔐 Testing admin2 User Login</h3>";

$sql = "SELECT * FROM users WHERE username = 'admin2' AND role = 'admin'";
$admin2_user = $db->fetch($sql);

if ($admin2_user) {
    echo "<p><strong>User found:</strong> " . $admin2_user['username'] . "</p>";
    echo "<div class='code-block'>
        <strong>ID:</strong> " . $admin2_user['id'] . "<br>
        <strong>Username:</strong> " . $admin2_user['username'] . "<br>
        <strong>Email:</strong> " . $admin2_user['email'] . "<br>
        <strong>Role:</strong> " . $admin2_user['role'] . "<br>
        <strong>Password Hash:</strong> " . $admin2_user['password'] . "<br>
        <strong>Created:</strong> " . $admin2_user['created_at'] . "
    </div>";
    
    // Test different passwords
    $test_passwords = ['admin2', 'admin123', 'password', '123456'];
    
    echo "<p><strong>Testing password verification:</strong></p>";
    foreach ($test_passwords as $test_pass) {
        if (password_verify($test_pass, $admin2_user['password'])) {
            echo "<div class='status status-success'>
                <h4>✅ Password Found: '$test_pass'</h4>
                <p>This password works for admin2 user.</p>
            </div>";
            break;
        }
    }
    
} else {
    echo "<p><strong>User 'admin2' not found in database.</strong></p>";
}

echo "</div>";

// Check verifyPassword function
echo "<div class='test-section'>
    <h3>🔍 Checking verifyPassword Function</h3>";

if (function_exists('verifyPassword')) {
    echo "<p><strong>✅ verifyPassword function exists</strong></p>";
    
    if ($admin2_user) {
        // Test with verifyPassword function
        foreach ($test_passwords as $test_pass) {
            if (verifyPassword($test_pass, $admin2_user['password'])) {
                echo "<div class='status status-success'>
                    <h4>✅ verifyPassword Success: '$test_pass'</h4>
                    <p>This password works with verifyPassword function.</p>
                </div>";
                break;
            }
        }
    }
} else {
    echo "<p><strong>❌ verifyPassword function not found</strong></p>";
    echo "<p>This might be the issue - the login.php uses verifyPassword() function but it's not defined.</p>";
}

echo "</div>";

// Fix password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean($_POST['username'] ?? 'admin2');
    $new_password = $_POST['password'] ?? 'admin2';
    
    // Create new password hash
    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update password
    $sql = "UPDATE users SET password = ? WHERE username = ? AND role = 'admin'";
    $result = $db->query($sql, [$new_hash, $username]);
    
    if ($result) {
        echo "<div class='status status-success'>
            <h3>✅ Password Updated Successfully!</h3>
            <p>Username: <strong>$username</strong></p>
            <p>New Password: <strong>$new_password</strong></p>
            <p>You can now login with these credentials.</p>
        </div>";
    } else {
        echo "<div class='status status-error'>
            <h3>❌ Password Update Failed</h3>
            <p>Please try again.</p>
        </div>";
    }
}

echo "<div class='test-section'>
    <h3>🔧 Fix Password</h3>
    <p>If password verification is failing, update the password below:</p>
    
    <form method='POST'>
        <div class='form-group'>
            <label>Username:</label>
            <input type='text' name='username' value='admin2' required>
        </div>
        
        <div class='form-group'>
            <label>New Password:</label>
            <input type='password' name='password' value='admin2' required>
        </div>
        
        <button type='submit' class='btn'>🔧 Update Password</button>
    </form>
</div>";

echo "<div style='text-align: center; margin-top: 40px;'>
    <button class='btn' onclick='window.location.href=\"admin/login.php\"'>🔐 Try Admin Login</button>
    <button class='btn' onclick='window.location.href=\"admin_debug.php\"'>🔍 Run Debug Again</button>
    <button class='btn btn-danger' onclick='window.location.href=\"index.php\"'>🏠 Back to Website</button>
</div>
</div>
</body>
</html>";
?>
