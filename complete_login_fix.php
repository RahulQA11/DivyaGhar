<?php
/**
 * Complete Login Fix Script
 * Test and fix admin login issues
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🔐 Complete Login Fix - Divyaghar</title>
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
            max-width: 900px;
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
        .user-test {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
        }
        .user-test h4 {
            color: #333;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>🔐 Complete Login Fix</h1>
            <p>Test and fix admin login issues</p>
        </div>";

// Get all admin users
echo "<div class='test-section'>
    <h3>👥 All Admin Users in Database</h3>";

$sql = "SELECT * FROM users WHERE role = 'admin'";
$admin_users = $db->fetchAll($sql);

if (count($admin_users) > 0) {
    echo "<p><strong>Found " . count($admin_users) . " admin user(s):</strong></p>";
    
    foreach ($admin_users as $user) {
        echo "<div class='user-test'>
            <h4>🔍 Testing User: " . $user['username'] . "</h4>
            <div class='code-block'>
                <strong>ID:</strong> " . $user['id'] . "<br>
                <strong>Username:</strong> " . $user['username'] . "<br>
                <strong>Email:</strong> " . $user['email'] . "<br>
                <strong>Role:</strong> " . $user['role'] . "<br>
                <strong>Password Hash:</strong> " . $user['password'] . "<br>
                <strong>Created:</strong> " . $user['created_at'] . "
            </div>";
            
            // Test common passwords
            $test_passwords = ['admin', 'admin123', 'password', '123456', $user['username']];
            $working_password = null;
            
            echo "<p><strong>Testing passwords:</strong></p>";
            foreach ($test_passwords as $test_pass) {
                if (password_verify($test_pass, $user['password'])) {
                    echo "<div class='status status-success'>
                        <h5>✅ Password Found: '$test_pass'</h5>
                        <p>This password works for " . $user['username'] . " user.</p>
                    </div>";
                    $working_password = $test_pass;
                    break;
                }
            }
            
            if (!$working_password) {
                echo "<div class='status status-error'>
                    <h5>❌ No Working Password Found</h5>
                    <p>None of the common passwords work for " . $user['username'] . " user.</p>
                </div>";
            }
            
            echo "</div>";
        }
} else {
    echo "<p><strong>No admin users found in database.</strong></p>";
}

echo "</div>";

// Test login simulation
echo "<div class='test-section'>
    <h3>🔐 Login Simulation Test</h3>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    echo "<div class='code-block'>
        <strong>Testing Login Simulation:</strong><br>
        Username: '$username'<br>
        Password: '$password'<br>
    </div>";
    
    // Simulate the exact login process from login.php
    $sql = "SELECT * FROM users WHERE username = ? AND role = 'admin'";
    $user = $db->fetch($sql, [$username]);
    
    echo "<div class='code-block'>
        <strong>SQL Query:</strong> $sql<br>
        <strong>Parameter:</strong> ['$username']<br>
        <strong>User Found:</strong> " . ($user ? 'YES' : 'NO') . "<br>
    </div>";
    
    if ($user) {
        echo "<div class='code-block'>
            <strong>User Data:</strong><br>
            ID: " . $user['id'] . "<br>
            Username: " . $user['username'] . "<br>
            Password Hash: " . $user['password'] . "<br>
        </div>";
        
        // Test password verification
        $password_check = verifyPassword($password, $user['password']);
        $direct_check = password_verify($password, $user['password']);
        
        echo "<div class='code-block'>
            <strong>Password Verification:</strong><br>
            verifyPassword(): " . ($password_check ? 'SUCCESS' : 'FAILED') . "<br>
            password_verify(): " . ($direct_check ? 'SUCCESS' : 'FAILED') . "<br>
        </div>";
        
        if ($password_check) {
            echo "<div class='status status-success'>
                <h4>✅ Login Simulation SUCCESS!</h4>
                <p>User '$username' can login with password '$password'</p>
            </div>";
        } else {
            echo "<div class='status status-error'>
                <h4>❌ Login Simulation FAILED!</h4>
                <p>Password verification failed for user '$username'</p>
            </div>";
        }
    } else {
        echo "<div class='status status-error'>
            <h4>❌ User Not Found!</h4>
            <p>No admin user found with username '$username'</p>
        </div>";
    }
}

echo "</div>";

// Password reset form
echo "<div class='test-section'>
    <h3>🔧 Reset Admin Password</h3>
    <p>If password verification is failing, reset the password below:</p>
    
    <form method='POST'>
        <div class='form-group'>
            <label>Select User:</label>
            <select name='username' required style='width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px;'>";
            
            foreach ($admin_users as $user) {
                echo "<option value='" . $user['username'] . "'>" . $user['username'] . " (" . $user['email'] . ")</option>";
            }
            
            echo "</select>
        </div>
        
        <div class='form-group'>
            <label>New Password:</label>
            <input type='password' name='password' value='admin123' required>
        </div>
        
        <div class='form-group'>
            <label>Confirm Password:</label>
            <input type='password' name='confirm_password' value='admin123' required>
        </div>
        
        <button type='submit' class='btn'>🔧 Reset Password</button>
    </form>
</div>";

// Process password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = clean($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password === $confirm_password) {
        // Create new password hash
        $new_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Update password
        $sql = "UPDATE users SET password = ? WHERE username = ? AND role = 'admin'";
        $result = $db->query($sql, [$new_hash, $username]);
        
        if ($result) {
            echo "<div class='status status-success'>
                <h3>✅ Password Reset Successfully!</h3>
                <p>Username: <strong>$username</strong></p>
                <p>New Password: <strong>$password</strong></p>
                <p>You can now login with these credentials.</p>
            </div>";
        } else {
            echo "<div class='status status-error'>
                <h3>❌ Password Reset Failed</h3>
                <p>Please try again.</p>
            </div>";
        }
    } else {
        echo "<div class='status status-error'>
            <h3>❌ Passwords Don't Match</h3>
            <p>Please enter the same password in both fields.</p>
        </div>";
    }
}

echo "<div style='text-align: center; margin-top: 40px;'>
    <button class='btn' onclick='window.location.href=\"admin/login.php\"'>🔐 Try Admin Login</button>
    <button class='btn' onclick='window.location.href=\"index.php\"'>🏠 Back to Website</button>
</div>
</div>
</body>
</html>";
?>
