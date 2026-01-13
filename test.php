<?php
/**
 * Simple Test Page
 * Divyaghar E-commerce Website
 */

echo "<h1>Divyaghar Website Test</h1>";
echo "<p>✓ PHP is working</p>";
echo "<p>✓ Files are loading</p>";

// Test database connection
try {
    require_once 'config/database.php';
    echo "<p>✓ Database configuration loaded</p>";
    
    if (isset($db) && $db) {
        echo "<p>✓ Database connection working</p>";
        
        // Simple test query
        $result = $db->query("SELECT 1 as test");
        $test = $result->fetch();
        
        if ($test['test'] == 1) {
            echo "<p>✓ Database query successful</p>";
        }
    }
} catch (Exception $e) {
    echo "<p>✗ Database error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>Try Homepage</a> | <a href='test_db.php'>Database Test</a></p>";
?>
