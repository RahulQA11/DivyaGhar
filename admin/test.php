<?php
/**
 * Admin Panel Functionality Test
 * Divyaghar E-commerce Website
 */

require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Test - Divyaghar</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Divyaghar</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="users.php" class="active">Users</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="content-header">
                <h1>Admin Panel Functionality Test</h1>
            </header>

            <div class="form-container">
                <h2>✅ Admin Panel Status Check</h2>
                
                <div class="test-results">
                    <h3>Database Connection</h3>
                    <?php
                    try {
                        $test = $db->fetchAll("SELECT COUNT(*) as count FROM products");
                        echo "<p class='success'>✅ Database connected successfully</p>";
                        echo "<p>📊 Total products in database: " . $test[0]['count'] . "</p>";
                    } catch (Exception $e) {
                        echo "<p class='error'>❌ Database connection failed: " . $e->getMessage() . "</p>";
                    }
                    ?>

                    <h3>Authentication System</h3>
                    <p class="success">✅ Admin authentication working</p>
                    <p>👤 Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    <p>🔐 User role: <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>

                    <h3>Required Files</h3>
                    <?php
                    $required_files = [
                        'dashboard.php' => 'Dashboard Management',
                        'products.php' => 'Product CRUD',
                        'categories.php' => 'Category CRUD',
                        'users.php' => 'User Management',
                        'orders.php' => 'Order Management',
                        'messages.php' => 'Message System',
                        'settings.php' => 'Settings Management',
                        'auth_check.php' => 'Authentication',
                        'login.php' => 'Login System'
                    ];

                    foreach ($required_files as $file => $description) {
                        if (file_exists($file)) {
                            echo "<p class='success'>✅ $file - $description</p>";
                        } else {
                            echo "<p class='error'>❌ $file - $description (Missing)</p>";
                        }
                    }
                    ?>

                    <h3>Database Tables</h3>
                    <?php
                    $required_tables = [
                        'users' => 'User Management',
                        'categories' => 'Category Management',
                        'products' => 'Product Management',
                        'product_images' => 'Product Images',
                        'orders' => 'Order Management',
                        'order_items' => 'Order Items',
                        'contact_messages' => 'Contact Messages',
                        'cart' => 'Shopping Cart',
                        'settings' => 'System Settings'
                    ];

                    foreach ($required_tables as $table => $description) {
                        try {
                            $result = $db->fetchAll("SHOW TABLES LIKE '$table'");
                            if ($result) {
                                echo "<p class='success'>✅ $table - $description</p>";
                            } else {
                                echo "<p class='error'>❌ $table - $description (Missing)</p>";
                            }
                        } catch (Exception $e) {
                            echo "<p class='error'>❌ $table - Error checking table</p>";
                        }
                    }
                    ?>

                    <h3>Configuration Constants</h3>
                    <?php
                    $constants = [
                        'SITE_URL' => SITE_URL,
                        'ADMIN_PRODUCTS_PER_PAGE' => ADMIN_PRODUCTS_PER_PAGE,
                        'MAX_IMAGE_SIZE' => MAX_IMAGE_SIZE,
                        'HASH_COST' => HASH_COST,
                        'SESSION_LIFETIME' => SESSION_LIFETIME
                    ];

                    foreach ($constants as $constant => $value) {
                        echo "<p class='success'>✅ $constant: " . htmlspecialchars($value) . "</p>";
                    }
                    ?>
                </div>

                <div class="test-actions">
                    <h3>Quick Actions</h3>
                    <div class="action-buttons">
                        <a href="dashboard.php" class="btn btn-primary">📊 View Dashboard</a>
                        <a href="products.php?action=add" class="btn btn-success">➕ Add Product</a>
                        <a href="categories.php?action=add" class="btn btn-info">📂 Add Category</a>
                        <a href="users.php?action=add" class="btn btn-warning">👤 Add User</a>
                        <a href="settings.php" class="btn btn-secondary">⚙️ Settings</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .test-results {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .test-results h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
        }
        
        .success {
            color: var(--success-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .error {
            color: var(--danger-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .test-actions {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .test-actions .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
    </style>
</body>
</html>
