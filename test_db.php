<?php
/**
 * Database Test File
 * Divyaghar E-commerce Website
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

try {
    // Include database configuration
    require_once 'config/database.php';
    
    echo "<p>✓ Database configuration loaded</p>";
    
    // Test database connection
    if ($db) {
        echo "<p>✓ Database connection successful</p>";
        
        // Test query
        $result = $db->query("SELECT COUNT(*) as count FROM categories");
        $count = $result->fetch();
        
        echo "<p>✓ Database query successful</p>";
        echo "<p>Categories in database: " . $count['count'] . "</p>";
        
        // Test products
        $products = $db->query("SELECT COUNT(*) as count FROM products");
        $product_count = $products->fetch();
        
        echo "<p>Products in database: " . $product_count['count'] . "</p>";
        
        echo "<p><strong>All tests passed! Database is working correctly.</strong></p>";
        
    } else {
        echo "<p>✗ Database connection failed</p>";
    }
    
} catch (Exception $e) {
    echo "<p>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='index.php'>Go to Homepage</a></p>";
?>
