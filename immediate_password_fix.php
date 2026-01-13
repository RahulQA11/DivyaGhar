<?php
/**
 * Immediate Password Fix
 * Fix admin password right now
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🔧 Immediate Password Fix - Divyaghar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 600px;
            background: rgba(255,255,255,0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
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
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
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
        .code-block {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            border-left: 4px solid #007bff;
            text-align: left;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 Immediate Password Fix</h1>";

// Fix admin user password
$username = 'admin';
$password = 'admin';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = ? WHERE username = ? AND role = 'admin'";
$result = $db->query($sql, [$hashed_password, $username]);

if ($result) {
    echo "<div class='status status-success'>
        <h2>✅ Admin Password Fixed!</h2>
        <p>Username: <strong>admin</strong></p>
        <p>Password: <strong>admin</strong></p>
        <p>You can now login with these credentials.</p>
    </div>";
    
    // Verify the fix
    $sql = "SELECT * FROM users WHERE username = 'admin' AND role = 'admin'";
    $user = $db->fetch($sql);
    
    if ($user && password_verify($password, $user['password'])) {
        echo "<div class='code-block'>
            <strong>Verification Successful:</strong><br>
            Username: admin<br>
            Password: admin<br>
            Password Hash: " . $user['password'] . "<br>
            Verification: ✅ PASSED
        </div>";
    }
    
} else {
    echo "<div class='status status-error'>
        <h2>❌ Password Fix Failed</h2>
        <p>Please try again.</p>
    </div>";
}

// Fix admin2 user password if exists
$sql = "SELECT * FROM users WHERE username = 'admin2' AND role = 'admin'";
$admin2_user = $db->fetch($sql);

if ($admin2_user) {
    $username2 = 'admin2';
    $password2 = 'admin2';
    $hashed_password2 = password_hash($password2, PASSWORD_DEFAULT);
    
    $sql = "UPDATE users SET password = ? WHERE username = ? AND role = 'admin'";
    $result2 = $db->query($sql, [$hashed_password2, $username2]);
    
    if ($result2) {
        echo "<div class='status status-success'>
            <h3>✅ Admin2 Password Also Fixed!</h3>
            <p>Username: <strong>admin2</strong></p>
            <p>Password: <strong>admin2</strong></p>
        </div>";
    }
}

echo "<div class='status status-warning'>
    <h3>🔐 Working Credentials</h3>
    <p><strong>Admin User:</strong></p>
    <p>Username: admin</p>
    <p>Password: admin</p>";
    
if ($admin2_user) {
    echo "<p><strong>Admin2 User:</strong></p>
    <p>Username: admin2</p>
    <p>Password: admin2</p>";
}

echo "</div>

echo "<div style='margin-top: 30px;'>
    <button class='btn' onclick='window.location.href=\"admin/login.php\"'>🔐 Try Admin Login Now</button>
    <button class='btn' onclick='window.location.href=\"complete_login_fix.php\"'>🔍 Verify Fix</button>
    <button class='btn btn-danger' onclick='window.location.href=\"index.php\"'>🏠 Back to Website</button>
</div>
</div>
</body>
</html>";
?>
