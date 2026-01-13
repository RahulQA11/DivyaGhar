<?php
/**
 * Create Admin User Script
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🔧 Create Admin User - Divyaghar</title>
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
            max-width: 600px;
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
            width: 100%;
        }
        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
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
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>🔧 Create Admin User</h1>
            <p>Add admin user to database</p>
        </div>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean($_POST['username'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }
    
    if (empty($errors)) {
        // Hash password
        $hashed_password = hashPassword($password);
        
        // Insert admin user
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')";
        $result = $db->query($sql, [$username, $email, $hashed_password]);
        
        if ($result) {
            echo "<div class='status status-success'>
                <h3>✅ Admin User Created Successfully!</h3>
                <p>Username: <strong>$username</strong></p>
                <p>Email: <strong>$email</strong></p>
                <p>You can now login with these credentials.</p>
            </div>";
        } else {
            echo "<div class='status status-error'>
                <h3>❌ Error Creating Admin User</h3>
                <p>Please check database connection and try again.</p>
            </div>";
        }
    }
}

echo "
        <div class='form-group'>
            <label>Username:</label>
            <input type='text' value='admin' readonly>
        </div>
        
        <div class='form-group'>
            <label>Email:</label>
            <input type='email' value='admin@divyaghar.com' readonly>
        </div>
        
        <div class='form-group'>
            <label>Password:</label>
            <input type='text' value='admin123' readonly>
        </div>
        
        <div class='status status-warning'>
            <h3>⚠️ Default Admin Credentials</h3>
            <p>Username: <strong>admin</strong></p>
            <p>Password: <strong>admin123</strong></p>
            <p>Click below to create this admin user.</p>
        </div>
        
        <form method='POST'>
            <div class='form-group'>
                <label>Username:</label>
                <input type='text' name='username' value='admin' required>
            </div>
            
            <div class='form-group'>
                <label>Email:</label>
                <input type='email' name='email' value='admin@divyaghar.com' required>
            </div>
            
            <div class='form-group'>
                <label>Password:</label>
                <input type='password' name='password' value='admin123' required>
            </div>
            
            <button type='submit' class='btn'>🔧 Create Admin User</button>
        </form>
        
        <div style='text-align: center; margin-top: 40px;'>
            <button class='btn' onclick='window.location.href=\"admin/login.php\"'>🔐 Go to Admin Login</button>
            <button class='btn' onclick='window.location.href=\"index.php\"'>🏠 Back to Website</button>
        </div>
    </div>
</body>
</html>";
?>
