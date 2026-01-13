<?php
/**
 * Enhanced Products Page with Pandit.com-Inspired Features
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

// Set page meta
$page_title = 'All Products - Divyaghar';
$meta_description = 'Browse our complete collection of high-quality pooja essentials, home décor, god idols, and spiritual gifts at Divyaghar.';
$meta_keywords = 'products, pooja essentials, home decor, god idols, spiritual gifts, divyaghar';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * 12;
$limit = 12;

// Get filters
$category_id = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'newest';

// Build query conditions
$where_conditions = ["p.status = 'active'"];
$params = [];

if (!empty($category_id)) {
    $where_conditions[] = "p.category_id = ?";
    $params[] = (int)$category_id;
}

if (!empty($search)) {
    $where_conditions[] = "(p.name LIKE ? OR p.description LIKE ? OR p.short_description LIKE ?)";
    $search_param = '%' . $search . '%';
    $params[] = $search_param;
}

if (!empty($min_price)) {
    $where_conditions[] = "p.price >= ?";
    $params[] = (float)$min_price;
}

if (!empty($max_price)) {
    $where_conditions[] = "p.price <= ?";
    $params[] = (float)$max_price;
}

// Get total products
$where_clause = implode(' AND ', $where_conditions);
$count_sql = "SELECT COUNT(*) as count FROM products p WHERE $where_clause";
$total_products = $db->fetch($count_sql, $params)['count'];
$total_pages = ceil($total_products / $limit);

// Get products
$sql = "SELECT p.*, c.name as category_name, c.slug as category_slug,
               (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 'yes' LIMIT 1) as primary_image
               FROM products p 
               LEFT JOIN categories c ON p.category_id = c.id 
               WHERE $where_clause 
               ORDER BY $sort LIMIT ? OFFSET ?";
$products = $db->fetchAll($sql, array_merge($params, [$limit, $offset]));

include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/style.css?v=<?php echo time(); ?>">
    <style>
        .product-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .product-image {
            position: relative;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
        }
        
        .product-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        
        .badge-new {
            background: #28a745;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        
        .badge-featured {
            background: #ffc107;
            color: #000;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        
        .badge-sale {
            background: #dc3545;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <div class="container">
            <a href="index.php">Home</a>
            <span>›</span>
            <span>All Products</span>
        </div>
    </nav>

    <!-- Products Header -->
    <section class="products-header-section">
        <div class="container">
            <div class="products-header-content">
                <h1>All Products</h1>
                <p>Discover our complete collection of spiritual and home décor items</p>
            </div>
        </div>
    </section>

    <!-- Filters and Products -->
    <section class="products-content">
        <div class="container">
            <div class="products-layout">
                <!-- Filters Sidebar -->
                <aside class="filters-sidebar">
                    <div class="filter-card">
                        <h3>Filters</h3>
                        
                        <!-- Search -->
                        <div class="filter-group">
                            <h4>Search</h4>
                            <form method="GET" action="">
                                <input type="text" name="search" placeholder="Search products..." 
                                       value="<?php echo htmlspecialchars($search); ?>">
                                <button type="submit" class="btn btn-outline btn-sm">Search</button>
                            </form>
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="filter-group">
                            <h4>Category</h4>
                            <form method="GET" action="">
                                <select name="category" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" 
                                                <?php echo ($category_id == $cat['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                        
                        <!-- Price Filter -->
                        <div class="filter-group">
                            <h4>Price Range</h4>
                            <form method="GET" action="">
                                <div class="price-inputs">
                                    <input type="number" name="min_price" placeholder="Min" 
                                           value="<?php echo htmlspecialchars($min_price); ?>" min="0">
                                    <span>-</span>
                                    <input type="number" name="max_price" placeholder="Max" 
                                           value="<?php echo htmlspecialchars($max_price); ?>" min="0">
                                </div>
                                <button type="submit" class="btn btn-outline btn-sm">Apply</button>
                            </form>
                        </div>
                        
                        <!-- Clear Filters -->
                        <div class="filter-actions">
                            <?php if (!empty($category_id) || !empty($min_price) || !empty($max_price) || !empty($search) || $sort !== 'newest'): ?>
                                <a href="products_enhanced_working.php" class="btn btn-secondary btn-sm">Clear All Filters</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </aside>
                
                <!-- Products Grid -->
                <div class="products-main">
                    <!-- Sorting and Results Count -->
                    <div class="products-header">
                        <div class="results-count">
                            <p>Showing <?php echo min($offset + 1, $total_products); ?>-<?php echo min($offset + $limit, $total_products); ?> of <?php echo $total_products; ?> products</p>
                        </div>
                        
                        <div class="sort-options">
                            <form method="GET" action="">
                                <select name="sort" onchange="this.form.submit()">
                                    <option value="newest" <?php echo ($sort === 'newest') ? 'selected' : ''; ?>>Newest First</option>
                                    <option value="price_low" <?php echo ($sort === 'price_low') ? 'selected' : ''; ?>>Price: Low to High</option>
                                    <option value="price_high" <?php echo ($sort === 'price_high') ? 'selected' : ''; ?>>Price: High to Low</option>
                                    <option value="name_asc" <?php echo ($sort === 'name_asc') ? 'selected' : ''; ?>>Name: A to Z</option>
                                    <option value="name_desc" <?php echo ($sort === 'name_desc') ? 'selected' : ''; ?>>Name: Z to A</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Products Grid -->
                    <div class="products-grid">
                        <?php if (empty($products)): ?>
                            <div class="no-products">
                                <h3>No products found</h3>
                                <p>Try adjusting your filters or browse our categories.</p>
                                <a href="products_enhanced_working.php" class="btn btn-primary btn-lg">Clear Filters</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <div class="product-card">
                                    <!-- Product Badges -->
                                    <div class="product-badges">
                                        <?php if ($product['featured'] === 'yes'): ?>
                                            <span class="badge-featured">Featured</span>
                                        <?php endif; ?>
                                        
                                        <?php if ($product['discount_price'] && $product['discount_price'] < $product['price']): ?>
                                            <span class="badge-sale">Sale</span>
                                        <?php endif; ?>
                                        
                                        <?php if (strtotime($product['created_at']) > strtotime('-7 days')): ?>
                                            <span class="badge-new">New</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Product Image -->
                                    <div class="product-image">
                                        <?php if ($product['primary_image']): ?>
                                            <img src="<?php echo SITE_URL; ?>uploads/<?php echo $product['primary_image']; ?>" 
                                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo SITE_URL; ?>assets/images/placeholder-product.jpg" 
                                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="product-details">
                                        <h3>
                                            <a href="product.php?slug=<?php echo $product['slug']; ?>">
                                                <?php echo htmlspecialchars($product['name']); ?>
                                            </a>
                                        </h3>
                                        
                                        <!-- Price -->
                                        <div class="product-price">
                                            <?php if ($product['discount_price']): ?>
                                                <span class="price-current">₹<?php echo number_format($product['discount_price'], 2); ?></span>
                                                <span class="price-original">₹<?php echo number_format($product['price'], 2); ?></span>
                                            <?php else: ?>
                                                <span class="price-current">₹<?php echo number_format($product['price'], 2); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Description -->
                                        <div class="product-description">
                                            <?php echo substr(strip_tags($product['description']), 0, 100); ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Product Actions -->
                                    <div class="product-actions">
                                        <a href="product.php?slug=<?php echo $product['slug']; ?>" class="btn btn-primary">View Details</a>
                                        <a href="cart.php?action=add&product_id=<?php echo $product['id']; ?>" class="btn btn-outline">Add to Cart</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="current-page"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <div class="pagination-info">
                        Page <?php echo $page; ?> of <?php echo $total_pages; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Simple Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Divyaghar. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
?>
