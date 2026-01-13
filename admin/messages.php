<?php
/**
 * Contact Messages Management
 * Divyaghar E-commerce Website
 */

require_once 'auth_check.php';

$action = $_GET['action'] ?? 'list';
$message_id = $_GET['id'] ?? null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * ADMIN_PRODUCTS_PER_PAGE;

// Handle status update
if ($action === 'update_status' && $message_id && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'] ?? '';
    $valid_statuses = ['new', 'read', 'replied'];
    
    if (in_array($new_status, $valid_statuses)) {
        $db->query("UPDATE contact_messages SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?", [$new_status, $message_id]);
        setFlashMessage('success', 'Message status updated successfully');
    } else {
        setFlashMessage('error', 'Invalid status');
    }
    redirect('admin/messages.php');
}

// Handle delete
if ($action === 'delete' && $message_id) {
    $db->query("DELETE FROM contact_messages WHERE id = ?", [$message_id]);
    setFlashMessage('success', 'Message deleted successfully');
    redirect('admin/messages.php');
}

// Get message details for view
$message = null;
if ($action === 'view' && $message_id) {
    $message = $db->fetch("SELECT * FROM contact_messages WHERE id = ?", [$message_id]);
    if (!$message) {
        setFlashMessage('error', 'Message not found');
        redirect('admin/messages.php');
    }
    
    // Mark as read if status is new
    if ($message['status'] === 'new') {
        $db->query("UPDATE contact_messages SET status = 'read' WHERE id = ?", [$message_id]);
        $message['status'] = 'read';
    }
}

// Get messages with pagination
$total_messages = $db->fetch("SELECT COUNT(*) as count FROM contact_messages")['count'];
$total_pages = ceil($total_messages / ADMIN_PRODUCTS_PER_PAGE);

$messages = $db->fetchAll("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT ? OFFSET ?", [ADMIN_PRODUCTS_PER_PAGE, $offset]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Divyaghar Admin</title>
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
                    <li><a href="messages.php" class="active">Messages</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1>Contact Messages</h1>
                <span class="badge badge-info">
                    <?php 
                    $new_count = $db->fetch("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'new'")['count'];
                    echo $new_count . ' New';
                    ?>
                </span>
            </header>

            <?php if ($message = getFlashMessage('success')): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($message = getFlashMessage('error')): ?>
                <div class="alert alert-error"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($action === 'view' && $message): ?>
                <!-- Message Details -->
                <div class="card">
                    <div class="card-header">
                        <h3>Message Details</h3>
                        <a href="messages.php" class="btn btn-secondary">Back to Messages</a>
                    </div>
                    <div class="card-content">
                        <div class="message-details">
                            <div class="message-header">
                                <div class="message-info">
                                    <h4><?php echo htmlspecialchars($message['subject']); ?></h4>
                                    <p class="message-meta">
                                        From: <?php echo htmlspecialchars($message['name']); ?> 
                                        &lt;<?php echo htmlspecialchars($message['email']); ?>&gt;
                                        <?php if ($message['phone']): ?>
                                            | Phone: <?php echo htmlspecialchars($message['phone']); ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="message-date">
                                        Received: <?php echo date('d M Y, h:i A', strtotime($message['created_at'])); ?>
                                    </p>
                                </div>
                                <div class="message-status">
                                    <span class="status status-<?php echo $message['status']; ?>">
                                        <?php echo ucfirst($message['status']); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="message-content">
                                <h5>Message:</h5>
                                <div class="message-text">
                                    <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                                </div>
                            </div>

                            <div class="message-actions">
                                <h5>Actions:</h5>
                                <form method="POST" action="?action=update_status&id=<?php echo $message_id; ?>">
                                    <div class="form-group">
                                        <label for="status">Update Status:</label>
                                        <select id="status" name="status">
                                            <option value="new" <?php echo $message['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                            <option value="read" <?php echo $message['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                                            <option value="replied" <?php echo $message['status'] === 'replied' ? 'selected' : ''; ?>>Replied</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </form>

                                <div class="action-links">
                                    <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>?subject=Re: <?php echo urlencode($message['subject']); ?>" 
                                       class="btn btn-success" target="_blank">Reply via Email</a>
                                    <a href="?action=delete&id=<?php echo $message_id; ?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('Are you sure you want to delete this message?')">Delete Message</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Messages List -->
                <div class="card">
                    <div class="card-content">
                        <?php if (empty($messages)): ?>
                            <p>No messages found.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>From</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($messages as $msg): ?>
                                            <tr class="<?php echo $msg['status'] === 'new' ? 'new-message' : ''; ?>">
                                                <td>
                                                    <strong><?php echo htmlspecialchars($msg['subject']); ?></strong>
                                                    <?php if ($msg['status'] === 'new'): ?>
                                                        <span class="badge badge-primary">New</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($msg['name']); ?>
                                                    <br><small class="text-muted"><?php echo htmlspecialchars($msg['email']); ?></small>
                                                </td>
                                                <td>
                                                    <?php echo date('d M Y', strtotime($msg['created_at'])); ?>
                                                    <br><small class="text-muted"><?php echo date('h:i A', strtotime($msg['created_at'])); ?></small>
                                                </td>
                                                <td>
                                                    <span class="status status-<?php echo $msg['status']; ?>">
                                                        <?php echo ucfirst($msg['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="?action=view&id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                                        <a href="?action=delete&id=<?php echo $msg['id']; ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php if ($total_pages > 1): ?>
                                <?php echo getPagination($page, $total_pages, 'messages.php?page=%d'); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
