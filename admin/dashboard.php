<?php
/**
 * Admin Dashboard
 * Divyaghar E-commerce Website
 */

require_once 'auth_check.php';

// Get dashboard statistics
$stats = [
    'total_products' => $db->fetch("SELECT COUNT(*) as count FROM products")['count'],
    'total_categories' => $db->fetch("SELECT COUNT(*) as count FROM categories")['count'],
    'total_orders' => $db->fetch("SELECT COUNT(*) as count FROM orders")['count'],
    'pending_orders' => $db->fetch("SELECT COUNT(*) as count FROM orders WHERE order_status = 'pending'")['count'],
    'total_revenue' => $db->fetch("SELECT SUM(total_amount) as total FROM orders WHERE order_status != 'cancelled'")['total'] ?? 0,
    'recent_orders' => $db->fetchAll("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5"),
    'low_stock_products' => $db->fetchAll("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.stock_quantity < 10 ORDER BY p.stock_quantity ASC LIMIT 5")
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Divyaghar Admin</title>
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
                    <li><a href="dashboard.php" class="active">Dashboard</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1>Dashboard</h1>
                <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            </header>

            <?php if ($message = getFlashMessage('success')): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($message = getFlashMessage('error')): ?>
                <div class="alert alert-error"><?php echo $message; ?></div>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon products-icon">
                        <span>📦</span>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['total_products']; ?></h3>
                        <p>Total Products</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon categories-icon">
                        <span>📁</span>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['total_categories']; ?></h3>
                        <p>Categories</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orders-icon">
                        <span>🛒</span>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['total_orders']; ?></h3>
                        <p>Total Orders</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon revenue-icon">
                        <span>💰</span>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo formatPrice($stats['total_revenue']); ?></h3>
                        <p>Total Revenue</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-grid">
                <!-- Recent Orders -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Recent Orders</h3>
                        <a href="orders.php" class="btn btn-sm">View All</a>
                    </div>
                    <div class="card-content">
                        <?php if (empty($stats['recent_orders'])): ?>
                            <p>No orders yet</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($stats['recent_orders'] as $order): ?>
                                            <tr>
                                                <td><?php echo $order['order_number']; ?></td>
                                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                                <td><?php echo formatPrice($order['total_amount']); ?></td>
                                                <td>
                                                    <span class="status status-<?php echo $order['order_status']; ?>">
                                                        <?php echo ucfirst($order['order_status']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Low Stock Alert</h3>
                        <span class="badge badge-danger"><?php echo count($stats['low_stock_products']); ?></span>
                    </div>
                    <div class="card-content">
                        <?php if (empty($stats['low_stock_products'])): ?>
                            <p>All products have sufficient stock</p>
                        <?php else: ?>
                            <div class="low-stock-list">
                                <?php foreach ($stats['low_stock_products'] as $product): ?>
                                    <div class="low-stock-item">
                                        <div>
                                            <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                            <span class="category"><?php echo htmlspecialchars($product['category_name']); ?></span>
                                        </div>
                                        <span class="stock-count"><?php echo $product['stock_quantity']; ?> left</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
