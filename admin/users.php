<?php
/**
 * Users Management
 * Divyaghar E-commerce Website
 */

require_once 'auth_check.php';

$action = $_GET['action'] ?? 'list';
$user_id = $_GET['id'] ?? null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * ADMIN_USERS_PER_PAGE;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $username = clean($_POST['username'] ?? '');
        $email = clean($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $first_name = clean($_POST['first_name'] ?? '');
        $last_name = clean($_POST['last_name'] ?? '');
        $phone = clean($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'customer';
        $status = $_POST['status'] ?? 'active';
        
        $errors = [];
        if (empty($username)) $errors['username'] = 'Username is required';
        if (empty($email)) $errors['email'] = 'Email is required';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format';
        if (empty($password)) $errors['password'] = 'Password is required';
        if ($password !== $confirm_password) $errors['confirm_password'] = 'Passwords do not match';
        if (strlen($password) < 6) $errors['password'] = 'Password must be at least 6 characters';
        
        // Check if username already exists
        if (empty($errors['username'])) {
            $existing = $db->fetch("SELECT id FROM users WHERE username = ?", [$username]);
            if ($existing) $errors['username'] = 'Username already exists';
        }
        
        // Check if email already exists
        if (empty($errors['email'])) {
            $existing = $db->fetch("SELECT id FROM users WHERE email = ?", [$email]);
            if ($existing) $errors['email'] = 'Email already exists';
        }
        
        if (empty($errors)) {
            $hashed_password = hashPassword($password);
            
            $sql = "INSERT INTO users (username, email, password, first_name, last_name, phone, role, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $params = [$username, $email, $hashed_password, $first_name, $last_name, $phone, $role, $status];
            
            $db->query($sql, $params);
            setFlashMessage('success', 'User added successfully');
            redirect('admin/users.php');
        }
    } elseif ($action === 'edit' && $user_id) {
        $username = clean($_POST['username'] ?? '');
        $email = clean($_POST['email'] ?? '');
        $first_name = clean($_POST['first_name'] ?? '');
        $last_name = clean($_POST['last_name'] ?? '');
        $phone = clean($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'customer';
        $status = $_POST['status'] ?? 'active';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        $errors = [];
        if (empty($username)) $errors['username'] = 'Username is required';
        if (empty($email)) $errors['email'] = 'Email is required';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format';
        
        if (!empty($password)) {
            if ($password !== $confirm_password) $errors['confirm_password'] = 'Passwords do not match';
            if (strlen($password) < 6) $errors['password'] = 'Password must be at least 6 characters';
        }
        
        // Check if username already exists (excluding current user)
        if (empty($errors['username'])) {
            $existing = $db->fetch("SELECT id FROM users WHERE username = ? AND id != ?", [$username, $user_id]);
            if ($existing) $errors['username'] = 'Username already exists';
        }
        
        // Check if email already exists (excluding current user)
        if (empty($errors['email'])) {
            $existing = $db->fetch("SELECT id FROM users WHERE email = ? AND id != ?", [$email, $user_id]);
            if ($existing) $errors['email'] = 'Email already exists';
        }
        
        if (empty($errors)) {
            if (!empty($password)) {
                $hashed_password = hashPassword($password);
                $sql = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, 
                        phone = ?, role = ?, status = ?, password = ? WHERE id = ?";
                $params = [$username, $email, $first_name, $last_name, $phone, $role, $status, $hashed_password, $user_id];
            } else {
                $sql = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, 
                        phone = ?, role = ?, status = ? WHERE id = ?";
                $params = [$username, $email, $first_name, $last_name, $phone, $role, $status, $user_id];
            }
            
            $db->query($sql, $params);
            setFlashMessage('success', 'User updated successfully');
            redirect('admin/users.php');
        }
    }
}

// Handle delete
if ($action === 'delete' && $user_id) {
    // Don't allow deletion of currently logged in admin
    if ($user_id != $_SESSION['user_id']) {
        $db->query("DELETE FROM users WHERE id = ?", [$user_id]);
        setFlashMessage('success', 'User deleted successfully');
    } else {
        setFlashMessage('error', 'Cannot delete your own account');
    }
    redirect('admin/users.php');
}

// Get data for forms
$user = null;
if ($action === 'edit' && $user_id) {
    $user = $db->fetch("SELECT * FROM users WHERE id = ?", [$user_id]);
    if (!$user) {
        setFlashMessage('error', 'User not found');
        redirect('admin/users.php');
    }
}

// Get users list
if ($action === 'list') {
    $search = clean($_GET['search'] ?? '');
    $role_filter = $_GET['role'] ?? '';
    $status_filter = $_GET['status'] ?? '';
    
    $where_conditions = [];
    $params = [];
    
    if (!empty($search)) {
        $where_conditions[] = "(username LIKE ? OR email LIKE ? OR first_name LIKE ? OR last_name LIKE ?)";
        $search_param = "%$search%";
        $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param]);
    }
    
    if (!empty($role_filter)) {
        $where_conditions[] = "role = ?";
        $params[] = $role_filter;
    }
    
    if (!empty($status_filter)) {
        $where_conditions[] = "status = ?";
        $params[] = $status_filter;
    }
    
    $where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';
    
    // Get total count
    $count_sql = "SELECT COUNT(*) as total FROM users $where_clause";
    $total_users = $db->fetch($count_sql, $params)['total'];
    $total_pages = ceil($total_users / ADMIN_USERS_PER_PAGE);
    
    // Get users
    $sql = "SELECT * FROM users $where_clause ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $users = $db->fetchAll($sql, array_merge($params, [ADMIN_USERS_PER_PAGE, $offset]));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - Divyaghar Admin</title>
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
                <h1>Users Management</h1>
                <a href="users.php?action=add" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </header>

            <?php if ($error = getFlashMessage('error')): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success = getFlashMessage('success')): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($action === 'list'): ?>
                <!-- Filters -->
                <div class="filters">
                    <form method="GET" class="filter-form">
                        <input type="text" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($search); ?>">
                        <select name="role">
                            <option value="">All Roles</option>
                            <option value="admin" <?php echo $role_filter === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="customer" <?php echo $role_filter === 'customer' ? 'selected' : ''; ?>>Customer</option>
                        </select>
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="active" <?php echo $status_filter === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $status_filter === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                        <button type="submit" class="btn btn-secondary">Filter</button>
                        <a href="users.php" class="btn btn-outline">Clear</a>
                    </form>
                </div>

                <!-- Users Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $user['role'] === 'admin' ? 'danger' : 'info'; ?>">
                                            <?php echo ucfirst($user['role']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo $user['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                            <?php echo ucfirst($user['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="users.php?action=edit&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                <a href="users.php?action=delete&id=<?php echo $user['id']; ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&role=<?php echo urlencode($role_filter); ?>&status=<?php echo urlencode($status_filter); ?>" 
                               class="page-link <?php echo $i === $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

            <?php elseif ($action === 'add' || $action === 'edit'): ?>
                <!-- Add/Edit User Form -->
                <div class="form-container">
                    <h2><?php echo $action === 'edit' ? 'Edit User' : 'Add New User'; ?></h2>
                    
                    <form method="POST" class="admin-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="username">Username *</label>
                                <input type="text" id="username" name="username" 
                                       value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                                <?php if (isset($errors['username'])): ?>
                                    <span class="error"><?php echo $errors['username']; ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                                <?php if (isset($errors['email'])): ?>
                                    <span class="error"><?php echo $errors['email']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" 
                                       value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" 
                                       value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="role">Role *</label>
                                <select id="role" name="role" required>
                                    <option value="customer" <?php echo ($user['role'] ?? '') === 'customer' ? 'selected' : ''; ?>>Customer</option>
                                    <option value="admin" <?php echo ($user['role'] ?? '') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status">
                                    <option value="active" <?php echo ($user['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($user['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password <?php echo $action === 'edit' ? '(leave blank to keep current)' : '*'; ?></label>
                                <input type="password" id="password" name="password" 
                                       <?php echo $action === 'add' ? 'required' : ''; ?>>
                                <?php if (isset($errors['password'])): ?>
                                    <span class="error"><?php echo $errors['password']; ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password <?php echo $action === 'add' ? '*' : ''; ?></label>
                                <input type="password" id="confirm_password" name="confirm_password" 
                                       <?php echo $action === 'add' ? 'required' : ''; ?>>
                                <?php if (isset($errors['confirm_password'])): ?>
                                    <span class="error"><?php echo $errors['confirm_password']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> <?php echo $action === 'edit' ? 'Update User' : 'Add User'; ?>
                            </button>
                            <a href="users.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
