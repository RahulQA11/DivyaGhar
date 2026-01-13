<?php
/**
 * Final Admin Access Test
 * Divyaghar E-commerce Website
 */

echo "<h1>🎯 Final Admin Access Test</h1>";

// Test 1: Check if all required files exist and can be included
echo "<h2>1. File Include Test</h2>";
$required_files = [
    '../config/database.php',
    '../includes/functions.php',
    'auth_check.php'
];

$all_files_ok = true;
foreach ($required_files as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $file - Exists</p>";
        try {
            require_once $file;
            echo "<p style='color: green;'>✅ $file - Included successfully</p>";
        } catch (Error $e) {
            echo "<p style='color: red;'>❌ $file - Include error: " . $e->getMessage() . "</p>";
            $all_files_ok = false;
        }
    } else {
        echo "<p style='color: red;'>❌ $file - Missing</p>";
        $all_files_ok = false;
    }
}

// Test 2: Check if functions are available
echo "<h2>2. Function Availability Test</h2>";
$required_functions = ['clean', 'redirect', 'setFlashMessage', 'getFlashMessage'];

foreach ($required_functions as $function) {
    if (function_exists($function)) {
        echo "<p style='color: green;'>✅ Function $function() - Available</p>";
    } else {
        echo "<p style='color: red;'>❌ Function $function() - Not available</p>";
        $all_files_ok = false;
    }
}

// Test 3: Database connection test
echo "<h2>3. Database Connection Test</h2>";
if ($all_files_ok) {
    try {
        require_once '../config/database.php';
        $test = $db->fetchAll("SELECT COUNT(*) as count FROM products");
        echo "<p style='color: green;'>✅ Database connection successful</p>";
        echo "<p>Products in database: " . $test[0]['count'] . "</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
    }
}

// Test 4: Session test
echo "<h2>4. Session Test</h2>";
session_start();
$_SESSION['test'] = 'working';
if (isset($_SESSION['test']) && $_SESSION['test'] === 'working') {
    echo "<p style='color: green;'>✅ Session management working</p>";
} else {
    echo "<p style='color: red;'>❌ Session management failed</p>";
}

echo "<h2>🚀 Access Links</h2>";
if ($all_files_ok) {
    echo "<p><a href='login_simple.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🚀 Simple Login (Recommended)</a></p>";
    echo "<p><a href='login.php' style='background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔐 Normal Login</a></p>";
    echo "<p><a href='dashboard.php' style='background: #ffc107; color: black; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>📊 Test Dashboard</a></p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>❌ Fix the errors above before accessing admin panel</p>";
}

echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; }";
echo "h1 { color: #B8860B; text-align: center; }";
echo "h2 { color: #8B4513; margin-top: 30px; border-bottom: 2px solid #8B4513; padding-bottom: 10px; }";
echo "</style>";
?>
