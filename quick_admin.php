<?php
/**
 * Quick Admin User Creation
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

// Create admin user
$username = 'admin';
$email = 'admin@divyaghar.com';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')";
$result = $db->query($sql, [$username, $email, $hashed_password]);

if ($result) {
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>✅ Admin User Created</title>
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
            max-width: 500px;
            background: rgba(255,255,255,0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
        }
        .success {
            background: #d4ed31;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <div class='container'>
        <div class='success'>
            <h2>✅ Admin User Created Successfully!</h2>
        </div>
        
        <h3>Admin Credentials:</h3>
        <p><strong>Username:</strong> admin</p>
        <p><strong>Password:</strong> admin123</p>
        
        <button class='btn' onclick='window.location.href=\"admin/login.php\"'>🔐 Go to Admin Login</button>
        <button class='btn' onclick='window.location.href=\"index.php\"'>🏠 Back to Website</button>
    </div>
</body>
</html>";
} else {
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>❌ Error</title>
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
            max-width: 500px;
            background: rgba(255,255,255,0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .btn {
            background: #dc3545;
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
            background: #c82333;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='error'>
            <h2>❌ Error Creating Admin User</h2>
            <p>Please check database connection and try again.</p>
        </div>
        
        <button class='btn' onclick='window.location.href=\"create_admin.php\"'>🔄 Try Again</button>
        <button class='btn' onclick='window.location.href=\"index.php\"'>🏠 Back to Website</button>
    </div>
</body>
</html>";
}
?>
