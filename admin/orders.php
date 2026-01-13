<?php
/**
 * Orders Management
 * Divyaghar E-commerce Website
 */

require_once 'auth_check.php';

$action = $_GET['action'] ?? 'list';
$order_id = $_GET['id'] ?? null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * ADMIN_PRODUCTS_PER_PAGE;

// Handle status update
if ($action === 'update_status' && $order_id && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['order_status'] ?? '';
    $valid_statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    
    if (in_array($new_status, $valid_statuses)) {
        $db->query("UPDATE orders SET order_status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?", [$new_status, $order_id]);
        setFlashMessage('success', 'Order status updated successfully');
    } else {
        setFlashMessage('error', 'Invalid status');
    }
    redirect('admin/orders.php');
}

// Get order details for view
$order = null;
$order_items = [];
if ($action === 'view' && $order_id) {
    $order = $db->fetch("SELECT * FROM orders WHERE id = ?", [$order_id]);
    if (!$order) {
        setFlashMessage('error', 'Order not found');
        redirect('admin/orders.php');
    }
    $order_items = $db->fetchAll("SELECT oi.*, p.name as current_product_name FROM order_items oi 
                                  LEFT JOIN products p ON oi.product_id = p.id 
                                  WHERE oi.order_id = ? ORDER BY oi.id ASC", [$order_id]);
}

// Get orders with pagination
$total_orders = $db->fetch("SELECT COUNT(*) as count FROM orders")['count'];
$total_pages = ceil($total_orders / ADMIN_PRODUCTS_PER_PAGE);

$orders = $db->fetchAll("SELECT * FROM orders ORDER BY created_at DESC LIMIT ? OFFSET ?", [ADMIN_PRODUCTS_PER_PAGE, $offset]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Divyaghar Admin</title>
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
                    <li><a href="orders.php" class="active">Orders</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1>Orders</h1>
            </header>

            <?php if ($message = getFlashMessage('success')): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($message = getFlashMessage('error')): ?>
                <div class="alert alert-error"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($action === 'view' && $order): ?>
                <!-- Order Details -->
                <div class="card">
                    <div class="card-header">
                        <h3>Order Details - <?php echo $order['order_number']; ?></h3>
                        <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
                    </div>
                    <div class="card-content">
                        <div class="order-details-grid">
                            <div class="order-info">
                                <h4>Order Information</h4>
                                <table class="order-info-table">
                                    <tr>
                                        <th>Order Number:</th>
                                        <td><?php echo $order['order_number']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Order Date:</th>
                                        <td><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method:</th>
                                        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status:</th>
                                        <td>
                                            <span class="status status-<?php echo $order['payment_status']; ?>">
                                                <?php echo ucfirst($order['payment_status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order Status:</th>
                                        <td>
                                            <span class="status status-<?php echo $order['order_status']; ?>">
                                                <?php echo ucfirst($order['order_status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="customer-info">
                                <h4>Customer Information</h4>
                                <table class="order-info-table">
                                    <tr>
                                        <th>Name:</th>
                                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="address-info">
                            <h4>Shipping Address</h4>
                            <p><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                        </div>

                        <?php if (!empty($order['billing_address'])): ?>
                            <div class="address-info">
                                <h4>Billing Address</h4>
                                <p><?php echo nl2br(htmlspecialchars($order['billing_address'])); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="order-items">
                            <h4>Order Items</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($order_items as $item): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                <td><?php echo $item['quantity']; ?></td>
                                                <td><?php echo formatPrice($item['price']); ?></td>
                                                <td><?php echo formatPrice($item['total']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="order-summary">
                            <h4>Order Summary</h4>
                            <table class="summary-table">
                                <tr>
                                    <th>Subtotal:</th>
                                    <td><?php echo formatPrice($order['subtotal']); ?></td>
                                </tr>
                                <tr>
                                    <th>Tax:</th>
                                    <td><?php echo formatPrice($order['tax_amount']); ?></td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td><?php echo formatPrice($order['shipping_amount']); ?></td>
                                </tr>
                                <tr class="total-row">
                                    <th>Total:</th>
                                    <td><?php echo formatPrice($order['total_amount']); ?></td>
                                </tr>
                            </table>
                        </div>

                        <?php if (!empty($order['notes'])): ?>
                            <div class="order-notes">
                                <h4>Order Notes</h4>
                                <p><?php echo nl2br(htmlspecialchars($order['notes'])); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="status-update">
                            <h4>Update Order Status</h4>
                            <form method="POST" action="?action=update_status&id=<?php echo $order_id; ?>">
                                <div class="form-group">
                                    <label for="order_status">Order Status:</label>
                                    <select id="order_status" name="order_status">
                                        <option value="pending" <?php echo $order['order_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="processing" <?php echo $order['order_status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                        <option value="shipped" <?php echo $order['order_status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                        <option value="delivered" <?php echo $order['order_status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        <option value="cancelled" <?php echo $order['order_status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Orders List -->
                <div class="card">
                    <div class="card-content">
                        <?php if (empty($orders)): ?>
                            <p>No orders found.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo $order['order_number']; ?></strong>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($order['customer_name']); ?>
                                                    <br><small class="text-muted"><?php echo htmlspecialchars($order['customer_email']); ?></small>
                                                </td>
                                                <td>
                                                    <?php echo date('d M Y', strtotime($order['created_at'])); ?>
                                                    <br><small class="text-muted"><?php echo date('h:i A', strtotime($order['created_at'])); ?></small>
                                                </td>
                                                <td>
                                                    <strong><?php echo formatPrice($order['total_amount']); ?></strong>
                                                </td>
                                                <td>
                                                    <span class="status status-<?php echo $order['payment_status']; ?>">
                                                        <?php echo ucfirst($order['payment_status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="status status-<?php echo $order['order_status']; ?>">
                                                        <?php echo ucfirst($order['order_status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="?action=view&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php if ($total_pages > 1): ?>
                                <?php echo getPagination($page, $total_pages, 'orders.php?page=%d'); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
