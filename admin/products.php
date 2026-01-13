<?php
/**
 * Products Management
 * Divyaghar E-commerce Website
 */

require_once 'auth_check.php';

$action = $_GET['action'] ?? 'list';
$product_id = $_GET['id'] ?? null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * ADMIN_PRODUCTS_PER_PAGE;

// Get categories for dropdown
$categories = $db->fetchAll("SELECT id, name FROM categories WHERE status = 'active' ORDER BY name ASC");

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $category_id = (int)$_POST['category_id'];
        $name = clean($_POST['name'] ?? '');
        $description = $_POST['description'] ?? '';
        $short_description = clean($_POST['short_description'] ?? '');
        $price = (float)$_POST['price'];
        $discount_price = !empty($_POST['discount_price']) ? (float)$_POST['discount_price'] : null;
        $sku = clean($_POST['sku'] ?? '');
        $stock_quantity = (int)$_POST['stock_quantity'];
        $weight = !empty($_POST['weight']) ? (float)$_POST['weight'] : null;
        $dimensions = clean($_POST['dimensions'] ?? '');
        $meta_title = clean($_POST['meta_title'] ?? '');
        $meta_description = clean($_POST['meta_description'] ?? '');
        $featured = $_POST['featured'] ?? 'no';
        $status = $_POST['status'] ?? 'active';
        
        $errors = [];
        if (empty($name)) $errors['name'] = 'Product name is required';
        if ($category_id <= 0) $errors['category_id'] = 'Please select a category';
        if ($price <= 0) $errors['price'] = 'Price must be greater than 0';
        if ($stock_quantity < 0) $errors['stock_quantity'] = 'Stock quantity cannot be negative';
        
        if (empty($errors)) {
            $slug = generateSlug($name);
            
            // Check if slug already exists
            $existing = $db->fetch("SELECT id FROM products WHERE slug = ?", [$slug]);
            if ($existing) {
                $slug .= '-' . time();
            }
            
            $sql = "INSERT INTO products (category_id, name, slug, description, short_description, price, 
                    discount_price, sku, stock_quantity, weight, dimensions, meta_title, meta_description, 
                    featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $params = [$category_id, $name, $slug, $description, $short_description, $price, 
                      $discount_price, $sku, $stock_quantity, $weight, $dimensions, $meta_title, 
                      $meta_description, $featured, $status];
            
            $db->query($sql, $params);
            $new_product_id = $db->lastInsertId();
            
            // Handle image uploads
            if (!empty($_FILES['images']['name'][0])) {
                $image_count = count($_FILES['images']['name']);
                for ($i = 0; $i < $image_count; $i++) {
                    $image_file = [
                        'name' => $_FILES['images']['name'][$i],
                        'type' => $_FILES['images']['type'][$i],
                        'tmp_name' => $_FILES['images']['tmp_name'][$i],
                        'error' => $_FILES['images']['error'][$i],
                        'size' => $_FILES['images']['size'][$i]
                    ];
                    
                    $upload_result = uploadImage($image_file, 'products');
                    if ($upload_result['success']) {
                        $is_primary = ($i === 0) ? 'yes' : 'no';
                        $sql = "INSERT INTO product_images (product_id, image_name, image_path, alt_text, is_primary, sort_order) 
                                VALUES (?, ?, ?, ?, ?, ?)";
                        $db->query($sql, [$new_product_id, $upload_result['filename'], $upload_result['path'], 
                                       $name, $is_primary, $i]);
                    }
                }
            }
            
            // Handle image URLs
            $image_urls = $_POST['image_urls'] ?? [];
            if (!empty($image_urls)) {
                foreach ($image_urls as $index => $url) {
                    if (!empty(trim($url))) {
                        $is_primary = ($index === 0) ? 'yes' : 'no';
                        $filename = 'url_' . time() . '_' . $index . '.jpg';
                        $sql = "INSERT INTO product_images (product_id, image_name, image_path, alt_text, is_primary, sort_order) 
                                VALUES (?, ?, ?, ?, ?, ?)";
                        $db->query($sql, [$new_product_id, $filename, $url, 
                                       'External image ' . ($index + 1), $is_primary, $i]);
                    }
                }
            }
            
            setFlashMessage('success', 'Product added successfully');
            redirect('admin/products.php');
        }
    } elseif ($action === 'edit' && $product_id) {
        $category_id = (int)$_POST['category_id'];
        $name = clean($_POST['name'] ?? '');
        $description = $_POST['description'] ?? '';
        $short_description = clean($_POST['short_description'] ?? '');
        $price = (float)$_POST['price'];
        $discount_price = !empty($_POST['discount_price']) ? (float)$_POST['discount_price'] : null;
        $sku = clean($_POST['sku'] ?? '');
        $stock_quantity = (int)$_POST['stock_quantity'];
        $weight = !empty($_POST['weight']) ? (float)$_POST['weight'] : null;
        $dimensions = clean($_POST['dimensions'] ?? '');
        $meta_title = clean($_POST['meta_title'] ?? '');
        $meta_description = clean($_POST['meta_description'] ?? '');
        $featured = $_POST['featured'] ?? 'no';
        $status = $_POST['status'] ?? 'active';
        
        $errors = [];
        if (empty($name)) $errors['name'] = 'Product name is required';
        if ($category_id <= 0) $errors['category_id'] = 'Please select a category';
        if ($price <= 0) $errors['price'] = 'Price must be greater than 0';
        if ($stock_quantity < 0) $errors['stock_quantity'] = 'Stock quantity cannot be negative';
        
        if (empty($errors)) {
            $slug = generateSlug($name);
            
            // Check if slug already exists (excluding current product)
            $existing = $db->fetch("SELECT id FROM products WHERE slug = ? AND id != ?", [$slug, $product_id]);
            if ($existing) {
                $slug .= '-' . time();
            }
            
            $sql = "UPDATE products SET category_id = ?, name = ?, slug = ?, description = ?, 
                    short_description = ?, price = ?, discount_price = ?, sku = ?, stock_quantity = ?, 
                    weight = ?, dimensions = ?, meta_title = ?, meta_description = ?, featured = ?, 
                    status = ? WHERE id = ?";
            
            $params = [$category_id, $name, $slug, $description, $short_description, $price, 
                      $discount_price, $sku, $stock_quantity, $weight, $dimensions, $meta_title, 
                      $meta_description, $featured, $status, $product_id];
            
            $db->query($sql, $params);
            
            // Handle new image uploads
            if (!empty($_FILES['images']['name'][0])) {
                $image_count = count($_FILES['images']['name']);
                for ($i = 0; $i < $image_count; $i++) {
                    $image_file = [
                        'name' => $_FILES['images']['name'][$i],
                        'type' => $_FILES['images']['type'][$i],
                        'tmp_name' => $_FILES['images']['tmp_name'][$i],
                        'error' => $_FILES['images']['error'][$i],
                        'size' => $_FILES['images']['size'][$i]
                    ];
                    
                    $upload_result = uploadImage($image_file, 'products');
                    if ($upload_result['success']) {
                        $sql = "INSERT INTO product_images (product_id, image_name, image_path, alt_text, is_primary, sort_order) 
                                VALUES (?, ?, ?, ?, ?, ?)";
                        $db->query($sql, [$product_id, $upload_result['filename'], $upload_result['path'], 
                                       $name, 'no', 999]);
                    }
                }
            }
            
            setFlashMessage('success', 'Product updated successfully');
            redirect('admin/products.php');
        }
    }
}

// Handle delete action
if ($action === 'delete' && $product_id) {
    // Delete product images
    $images = $db->fetchAll("SELECT image_path FROM product_images WHERE product_id = ?", [$product_id]);
    foreach ($images as $image) {
        deleteImage($image['image_path']);
    }
    
    // Delete product (cascade will handle related records)
    $db->query("DELETE FROM products WHERE id = ?", [$product_id]);
    setFlashMessage('success', 'Product deleted successfully');
    redirect('admin/products.php');
}

// Handle delete image action
if ($action === 'delete_image' && isset($_GET['image_id'])) {
    $image_id = $_GET['image_id'];
    $image = $db->fetch("SELECT * FROM product_images WHERE id = ?", [$image_id]);
    if ($image) {
        deleteImage($image['image_path']);
        $db->query("DELETE FROM product_images WHERE id = ?", [$image_id]);
        setFlashMessage('success', 'Image deleted successfully');
    }
    redirect("admin/products.php?action=edit&id=$product_id");
}

// Handle set primary image
if ($action === 'set_primary' && isset($_GET['image_id'])) {
    $image_id = $_GET['image_id'];
    $product_id = $_GET['product_id'];
    
    // Reset all images to non-primary
    $db->query("UPDATE product_images SET is_primary = 'no' WHERE product_id = ?", [$product_id]);
    
    // Set selected image as primary
    $db->query("UPDATE product_images SET is_primary = 'yes' WHERE id = ?", [$image_id]);
    
    setFlashMessage('success', 'Primary image updated successfully');
    redirect("admin/products.php?action=edit&id=$product_id");
}

// Get product for editing
$product = null;
$product_images = [];
if ($action === 'edit' && $product_id) {
    $product = $db->fetch("SELECT * FROM products WHERE id = ?", [$product_id]);
    if (!$product) {
        setFlashMessage('error', 'Product not found');
        redirect('admin/products.php');
    }
    $product_images = $db->fetchAll("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC", [$product_id]);
}

// Get products with pagination
$total_products = $db->fetch("SELECT COUNT(*) as count FROM products")['count'];
$total_pages = ceil($total_products / ADMIN_PRODUCTS_PER_PAGE);

$products = $db->fetchAll("SELECT p.*, c.name as category_name FROM products p 
                          LEFT JOIN categories c ON p.category_id = c.id 
                          ORDER BY p.created_at DESC 
                          LIMIT ? OFFSET ?", [ADMIN_PRODUCTS_PER_PAGE, $offset]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Divyaghar Admin</title>
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
                    <li><a href="products.php" class="active">Products</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1>Products</h1>
                <a href="?action=add" class="btn btn-primary">Add Product</a>
            </header>

            <?php if ($message = getFlashMessage('success')): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($message = getFlashMessage('error')): ?>
                <div class="alert alert-error"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($action === 'add' || $action === 'edit'): ?>
                <!-- Add/Edit Product Form -->
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo $action === 'add' ? 'Add Product' : 'Edit Product'; ?></h3>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="name">Product Name *</label>
                                    <input type="text" id="name" name="name" 
                                           value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
                                    <?php if (isset($errors['name'])): ?>
                                        <span class="error"><?php echo $errors['name']; ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="category_id">Category *</label>
                                    <select id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo $cat['id']; ?>" 
                                                    <?php echo (($product['category_id'] ?? '') == $cat['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($cat['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($errors['category_id'])): ?>
                                        <span class="error"><?php echo $errors['category_id']; ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="price">Price *</label>
                                    <input type="number" id="price" name="price" step="0.01" min="0"
                                           value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>" required>
                                    <?php if (isset($errors['price'])): ?>
                                        <span class="error"><?php echo $errors['price']; ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="discount_price">Discount Price</label>
                                    <input type="number" id="discount_price" name="discount_price" step="0.01" min="0"
                                           value="<?php echo htmlspecialchars($product['discount_price'] ?? ''); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="sku">SKU</label>
                                    <input type="text" id="sku" name="sku" 
                                           value="<?php echo htmlspecialchars($product['sku'] ?? ''); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="stock_quantity">Stock Quantity *</label>
                                    <input type="number" id="stock_quantity" name="stock_quantity" min="0"
                                           value="<?php echo htmlspecialchars($product['stock_quantity'] ?? 0); ?>" required>
                                    <?php if (isset($errors['stock_quantity'])): ?>
                                        <span class="error"><?php echo $errors['stock_quantity']; ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="weight">Weight (kg)</label>
                                    <input type="number" id="weight" name="weight" step="0.01" min="0"
                                           value="<?php echo htmlspecialchars($product['weight'] ?? ''); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="dimensions">Dimensions</label>
                                    <input type="text" id="dimensions" name="dimensions" 
                                           value="<?php echo htmlspecialchars($product['dimensions'] ?? ''); ?>"
                                           placeholder="e.g., 10x5x8 cm">
                                </div>

                                <div class="form-group">
                                    <label for="featured">Featured</label>
                                    <select id="featured" name="featured">
                                        <option value="no" <?php echo ($product['featured'] ?? 'no') === 'no' ? 'selected' : ''; ?>>No</option>
                                        <option value="yes" <?php echo ($product['featured'] ?? '') === 'yes' ? 'selected' : ''; ?>>Yes</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status">
                                        <option value="active" <?php echo ($product['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($product['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short_description">Short Description</label>
                                <textarea id="short_description" name="short_description" rows="2"><?php echo htmlspecialchars($product['short_description'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="description">Description *</label>
                                <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" id="meta_title" name="meta_title" 
                                       value="<?php echo htmlspecialchars($product['meta_title'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="2"><?php echo htmlspecialchars($product['meta_description'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Product Images</label>
                                <input type="file" name="images[]" multiple accept="image/*">
                                <small>Upload multiple images. First image will be set as primary.</small>
                                
                                <?php if ($action === 'edit' && !empty($product_images)): ?>
                                    <div class="existing-images">
                                        <h4>Current Images:</h4>
                                        <div class="image-grid">
                                            <?php foreach ($product_images as $image): ?>
                                                <div class="image-item">
                                                    <img src="<?php echo SITE_URL . $image['image_path']; ?>" alt="<?php echo htmlspecialchars($image['alt_text']); ?>">
                                                    <div class="image-actions">
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('Delete this image?')) window.location.href='?action=delete_image&image_id=<?php echo $image['id']; ?>&id=<?php echo $product_id; ?>'">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <?php if ($image['is_primary'] !== 'yes'): ?>
                                                            <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='?action=set_primary&image_id=<?php echo $image['id']; ?>&id=<?php echo $product_id; ?>'">
                                                                <i class="fas fa-star"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Image URLs (Optional)</label>
                                <div id="image-urls-container">
                                    <div class="image-url-input">
                                        <input type="url" name="image_urls[]" placeholder="Enter image URL...">
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="addImageUrlInput()">+</button>
                                    </div>
                                </div>
                                <small>Enter external image URLs if you don't want to upload files.</small>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo $action === 'add' ? 'Add Product' : 'Update Product'; ?>
                                </button>
                                <a href="products.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <!-- Products List -->
                <div class="card">
                    <div class="card-content">
                        <?php if (empty($products)): ?>
                            <p>No products found. <a href="?action=add">Add your first product</a></p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Featured</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $primary_image = $db->fetch("SELECT image_path FROM product_images WHERE product_id = ? AND is_primary = 'yes' LIMIT 1", [$product['id']]);
                                                    if ($primary_image): ?>
                                                        <img src="<?php echo SITE_URL . 'uploads/' . $primary_image['image_path']; ?>" 
                                                             alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-thumb">
                                                    <?php else: ?>
                                                        <div class="no-image">No Image</div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                                    <br><small class="text-muted"><?php echo $product['sku']; ?></small>
                                                </td>
                                                <td><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                                                <td>
                                                    <?php echo formatPrice($product['price']); ?>
                                                    <?php if ($product['discount_price']): ?>
                                                        <br><small class="text-success"><?php echo formatPrice($product['discount_price']); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="<?php echo $product['stock_quantity'] <= 10 ? 'text-danger' : ''; ?>">
                                                        <?php echo $product['stock_quantity']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo $product['featured'] === 'yes' ? 'success' : 'secondary'; ?>">
                                                        <?php echo ucfirst($product['featured']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="status status-<?php echo $product['status']; ?>">
                                                        <?php echo ucfirst($product['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="?action=edit&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                                        <a href="?action=delete&id=<?php echo $product['id']; ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php if ($total_pages > 1): ?>
                                <?php echo getPagination($page, $total_pages, 'products.php?page=%d'); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
    
    <script>
        function addImageUrlInput() {
            const container = document.getElementById('image-urls-container');
            const newInput = document.createElement('div');
            newInput.className = 'image-url-input';
            newInput.innerHTML = `
                <input type="url" name="image_urls[]" placeholder="Enter image URL...">
                <button type="button" class="btn btn-sm btn-secondary" onclick="this.parentElement.remove()">×</button>
            `;
            container.appendChild(newInput);
        }
        
        function deleteImage(imageId) {
            if (confirm('Are you sure you want to delete this image?')) {
                window.location.href = '?action=delete_image&image_id=' + imageId + '&id=<?php echo $product_id; ?>';
            }
        }
        
        function setPrimaryImage(imageId) {
            if (confirm('Set this as the primary image?')) {
                window.location.href = '?action=set_primary&image_id=' + imageId + '&id=<?php echo $product_id; ?>';
            }
        }
        
        // Preview image on click
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'IMG' && e.target.closest('.existing-images')) {
                const modal = document.createElement('div');
                modal.className = 'image-preview-modal';
                modal.innerHTML = `
                    <div class="modal-content">
                        <span class="close-btn" onclick="this.parentElement.remove()">&times;</span>
                        <img src="${e.target.src}" alt="${e.target.alt}" style="max-width: 90vw; max-height: 90vh;">
                    </div>
                `;
                document.body.appendChild(modal);
                
                // Close modal on background click
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.remove();
                    }
                });
            }
        });
    </script>
</body>
</html>
