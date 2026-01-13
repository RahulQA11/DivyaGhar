<?php
/**
 * Admin Access Debug & Fix
 * Divyaghar E-commerce Website
 */

// Start session manually
session_start();

echo "<h1>🔧 Admin Access Debug & Fix</h1>";

// Test 1: Check if we can connect to database
echo "<h2>1. Database Connection Test</h2>";
try {
    require_once '../config/database.php';
    $test = $db->fetchAll("SELECT COUNT(*) as count FROM users");
    echo "<p style='color: green;'>✅ Database connection: SUCCESS</p>";
    echo "<p>Users in database: " . $test[0]['count'] . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database connection: FAILED</p>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

// Test 2: Check if admin user exists
echo "<h2>2. Admin User Check</h2>";
try {
    $admin_check = $db->fetch("SELECT * FROM users WHERE username = 'admin'");
    if ($admin_check) {
        echo "<p style='color: green;'>✅ Admin user found in database</p>";
        echo "<p>Username: " . htmlspecialchars($admin_check['username']) . "</p>";
        echo "<p>Email: " . htmlspecialchars($admin_check['email']) . "</p>";
        echo "<p>Role: " . htmlspecialchars($admin_check['role']) . "</p>";
        
        // Test password verification
        if (password_verify('admin123', $admin_check['password'])) {
            echo "<p style='color: green;'>✅ Password verification: SUCCESS</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Password verification: FAILED</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Admin user NOT found in database</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error checking admin user: " . $e->getMessage() . "</p>";
}

// Test 3: Create admin user if not exists
echo "<h2>3. Create Admin User (if needed)</h2>";
if (!isset($admin_check) || !$admin_check) {
    echo "<p style='color: orange;'>Creating admin user...</p>";
    try {
        $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password, role, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?)";
        $db->query($sql, ['admin', 'admin@divyaghar.com', $hashed_password, 'admin', 'Admin', 'User']);
        echo "<p style='color: green;'>✅ Admin user created successfully</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error creating admin user: " . $e->getMessage() . "</p>";
    }
}

// Test 4: Session Test
echo "<h2>4. Session Management Test</h2>";
echo "<p>Current session data:</p>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Test 5: Direct Login Simulation
echo "<h2>5. Direct Login Simulation</h2>";
echo "<form method='post'>";
echo "<input type='hidden' name='force_login' value='1'>";
echo "<button type='submit' style='padding: 10px 20px; background: #B8860B; color: white; border: none; cursor: pointer;'>🚀 Force Admin Login</button>";
echo "</form>";

if (isset($_POST['force_login'])) {
    // Get admin user from database
    try {
        $admin_user = $db->fetch("SELECT * FROM users WHERE username = 'admin'");
        if ($admin_user && password_verify('admin123', $admin_user['password'])) {
            // Set session manually
            $_SESSION['user_id'] = $admin_user['id'];
            $_SESSION['username'] = $admin_user['username'];
            $_SESSION['user_role'] = $admin_user['role'];
            $_SESSION['login_time'] = time();
            $_SESSION['admin_logged_in'] = true;
            
            echo "<p style='color: green; font-weight: bold;'>✅ LOGIN SUCCESSFUL!</p>";
            echo "<p>Redirecting to dashboard in 3 seconds...</p>";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 3000);
            </script>";
        } else {
            echo "<p style='color: red;'>❌ Login failed: Invalid credentials</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Login error: " . $e->getMessage() . "</p>";
    }
}

echo "<hr>";
echo "<h2>🔧 Quick Access Links</h2>";
echo "<p><a href='login_simple.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; margin: 5px;'>🚀 Simple Login (Recommended)</a></p>";
echo "<p><a href='dashboard.php' style='background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; margin: 5px;'>📊 Go to Dashboard</a></p>";
echo "<p><a href='../' style='background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; margin: 5px;'>🏠 Go to Main Website</a></p>";

echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #B8860B; }
h2 { color: #8B4513; margin-top: 30px; }
pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; }
</style>";
?>
