<?php
/**
 * Database Setup Script
 * Creates database and imports schema
 */

// Database configuration (update these if needed)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'divyaghar_db';

echo "Setting up database...\n\n";

try {
    // Try different connection methods for macOS
    $connection_strings = [
        "mysql:host=$db_host;charset=utf8mb4",
        "mysql:host=127.0.0.1;charset=utf8mb4",
        "mysql:unix_socket=/tmp/mysql.sock;charset=utf8mb4",
        "mysql:unix_socket=/var/mysql/mysql.sock;charset=utf8mb4",
    ];
    
    $pdo = null;
    $last_error = null;
    
    foreach ($connection_strings as $dsn) {
        try {
            $pdo = new PDO($dsn, $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "✓ Connected using: $dsn\n";
            break;
        } catch (PDOException $e) {
            $last_error = $e;
            continue;
        }
    }
    
    if (!$pdo) {
        throw $last_error;
    }
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Database '$db_name' created or already exists\n";
    
    // Select the database
    $pdo->exec("USE `$db_name`");
    echo "✓ Using database '$db_name'\n\n";
    
    // Read SQL file
    $sql_file = __DIR__ . '/database.sql';
    if (!file_exists($sql_file)) {
        die("Error: database.sql file not found!\n");
    }
    
    $sql = file_get_contents($sql_file);
    
    // Remove database creation and USE statements (already handled)
    $sql = preg_replace('/CREATE DATABASE[^;]+;/i', '', $sql);
    $sql = preg_replace('/USE[^;]+;/i', '', $sql);
    
    // Split SQL into individual statements
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && 
                   !preg_match('/^(SET|START|COMMIT|--)/i', $stmt);
        }
    );
    
    echo "Importing schema...\n";
    
    // Execute each statement
    $pdo->beginTransaction();
    try {
        foreach ($statements as $statement) {
            if (!empty(trim($statement))) {
                $pdo->exec($statement);
            }
        }
        $pdo->commit();
        echo "✓ Schema imported successfully\n\n";
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
    
    // Verify tables were created
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "✓ Created " . count($tables) . " tables: " . implode(', ', $tables) . "\n\n";
    
    // Check for admin user
    $admin = $pdo->query("SELECT username, email FROM users WHERE role = 'admin' LIMIT 1")->fetch();
    if ($admin) {
        echo "✓ Admin user found:\n";
        echo "  Username: " . $admin['username'] . "\n";
        echo "  Email: " . $admin['email'] . "\n";
        echo "  Default password: admin123\n\n";
    }
    
    // Check for sample data
    $categories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    $products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    
    echo "✓ Sample data:\n";
    echo "  Categories: $categories\n";
    echo "  Products: $products\n\n";
    
    echo "Database setup completed successfully!\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting:\n";
    echo "1. Make sure MySQL server is running:\n";
    echo "   - macOS (Homebrew): brew services start mysql\n";
    echo "   - macOS (manual): mysql.server start\n";
    echo "   - Linux: sudo systemctl start mysql\n";
    echo "\n2. Verify MySQL is accessible:\n";
    echo "   mysql -u root -e \"SELECT VERSION();\"\n";
    echo "\n3. Update database credentials in this script if needed:\n";
    echo "   Edit setup_database.php and change \$db_user and \$db_pass\n";
    echo "\n4. For detailed instructions, see SETUP_INSTRUCTIONS.md\n";
    exit(1);
}
?>

