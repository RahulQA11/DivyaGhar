<?php
/**
 * Categories Management
 * Divyaghar E-commerce Website
 */

require_once 'auth_check.php';

$action = $_GET['action'] ?? 'list';
$category_id = $_GET['id'] ?? null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $name = clean($_POST['name'] ?? '');
        $description = clean($_POST['description'] ?? '');
        $meta_title = clean($_POST['meta_title'] ?? '');
        $meta_description = clean($_POST['meta_description'] ?? '');
        $status = $_POST['status'] ?? 'active';
        
        $errors = [];
        if (empty($name)) $errors['name'] = 'Category name is required';
        
        if (empty($errors)) {
            $slug = generateSlug($name);
            
            // Check if slug already exists
            $existing = $db->fetch("SELECT id FROM categories WHERE slug = ?", [$slug]);
            if ($existing) {
                $slug .= '-' . time();
            }
            
            $sql = "INSERT INTO categories (name, slug, description, meta_title, meta_description, status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $db->query($sql, [$name, $slug, $description, $meta_title, $meta_description, $status]);
            setFlashMessage('success', 'Category added successfully');
            redirect('admin/categories.php');
        }
    } elseif ($action === 'edit' && $category_id) {
        $name = clean($_POST['name'] ?? '');
        $description = clean($_POST['description'] ?? '');
        $meta_title = clean($_POST['meta_title'] ?? '');
        $meta_description = clean($_POST['meta_description'] ?? '');
        $status = $_POST['status'] ?? 'active';
        
        $errors = [];
        if (empty($name)) $errors['name'] = 'Category name is required';
        
        if (empty($errors)) {
            $slug = generateSlug($name);
            
            // Check if slug already exists (excluding current category)
            $existing = $db->fetch("SELECT id FROM categories WHERE slug = ? AND id != ?", [$slug, $category_id]);
            if ($existing) {
                $slug .= '-' . time();
            }
            
            $sql = "UPDATE categories SET name = ?, slug = ?, description = ?, meta_title = ?, 
                    meta_description = ?, status = ? WHERE id = ?";
            
            $db->query($sql, [$name, $slug, $description, $meta_title, $meta_description, $status, $category_id]);
            setFlashMessage('success', 'Category updated successfully');
            redirect('admin/categories.php');
        }
    }
}

// Handle delete action
if ($action === 'delete' && $category_id) {
    // Check if category has products
    $product_count = $db->fetch("SELECT COUNT(*) as count FROM products WHERE category_id = ?", [$category_id])['count'];
    
    if ($product_count > 0) {
        setFlashMessage('error', 'Cannot delete category. It contains products.');
    } else {
        $db->query("DELETE FROM categories WHERE id = ?", [$category_id]);
        setFlashMessage('success', 'Category deleted successfully');
    }
    redirect('admin/categories.php');
}

// Get category for editing
$category = null;
if ($action === 'edit' && $category_id) {
    $category = $db->fetch("SELECT * FROM categories WHERE id = ?", [$category_id]);
    if (!$category) {
        setFlashMessage('error', 'Category not found');
        redirect('admin/categories.php');
    }
}

// Get all categories
$categories = $db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Divyaghar Admin</title>
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
                    <li><a href="categories.php" class="active">Categories</a></li>
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
                <h1>Categories</h1>
                <a href="?action=add" class="btn btn-primary">Add Category</a>
            </header>

            <?php if ($message = getFlashMessage('success')): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($message = getFlashMessage('error')): ?>
                <div class="alert alert-error"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($action === 'add' || $action === 'edit'): ?>
                <!-- Add/Edit Category Form -->
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo $action === 'add' ? 'Add Category' : 'Edit Category'; ?></h3>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="name">Category Name *</label>
                                    <input type="text" id="name" name="name" 
                                           value="<?php echo htmlspecialchars($category['name'] ?? ''); ?>" required>
                                    <?php if (isset($errors['name'])): ?>
                                        <span class="error"><?php echo $errors['name']; ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status">
                                        <option value="active" <?php echo ($category['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($category['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="3"><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" id="meta_title" name="meta_title" 
                                       value="<?php echo htmlspecialchars($category['meta_title'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="2"><?php echo htmlspecialchars($category['meta_description'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo $action === 'add' ? 'Add Category' : 'Update Category'; ?>
                                </button>
                                <a href="categories.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <!-- Categories List -->
                <div class="card">
                    <div class="card-content">
                        <?php if (empty($categories)): ?>
                            <p>No categories found. <a href="?action=add">Add your first category</a></p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Products</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $cat): ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($cat['name']); ?></strong>
                                                    <br><small class="text-muted"><?php echo $cat['slug']; ?></small>
                                                </td>
                                                <td><?php echo truncateText($cat['description'], 50); ?></td>
                                                <td>
                                                    <span class="status status-<?php echo $cat['status']; ?>">
                                                        <?php echo ucfirst($cat['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $product_count = $db->fetch("SELECT COUNT(*) as count FROM products WHERE category_id = ?", [$cat['id']])['count'];
                                                    echo $product_count;
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="?action=edit&id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                                        <a href="?action=delete&id=<?php echo $cat['id']; ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
