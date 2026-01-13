<?php
/**
 * Category Page
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

// Get category slug from URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    redirect('index.php');
}

// Get category details
$category = $db->fetch("SELECT * FROM categories WHERE slug = ? AND status = 'active'", [$slug]);

if (!$category) {
    setFlashMessage('error', 'Category not found');
    redirect('index.php');
}

// Set page meta
$page_title = $category['meta_title'] ?? $category['name'] . ' - Divyaghar';
$meta_description = $category['meta_description'] ?? 'Explore our collection of ' . $category['name'] . ' at Divyaghar. High-quality spiritual items for your sacred space.';
$meta_keywords = $category['name'] . ', spiritual items, pooja essentials, divyaghar, ' . strtolower($category['name']);

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * PRODUCTS_PER_PAGE;

// Get total products in category
$total_products = $db->fetch("SELECT COUNT(*) as count FROM products WHERE category_id = ? AND status = 'active'", [$category['id']])['count'];
$total_pages = ceil($total_products / PRODUCTS_PER_PAGE);

// Get products in category
$products = $db->fetchAll("SELECT p.*, (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 'yes' LIMIT 1) as primary_image
                           FROM products p 
                           WHERE p.category_id = ? AND p.status = 'active' 
                           ORDER BY p.featured = 'yes' DESC, p.created_at DESC 
                           LIMIT ? OFFSET ?", [$category['id'], PRODUCTS_PER_PAGE, $offset]);

// Price filter
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$sort = $_GET['sort'] ?? 'newest';

// Apply filters
$where_conditions = ["p.category_id = ?", "p.status = 'active'"];
$params = [$category['id']];

if (!empty($min_price)) {
    $where_conditions[] = "p.price >= ?";
    $params[] = (float)$min_price;
}

if (!empty($max_price)) {
    $where_conditions[] = "p.price <= ?";
    $params[] = (float)$max_price;
}

// Sorting
$order_by = "p.featured = 'yes' DESC, p.created_at DESC";
switch ($sort) {
    case 'price_low':
        $order_by = "p.price ASC";
        break;
    case 'price_high':
        $order_by = "p.price DESC";
        break;
    case 'name_asc':
        $order_by = "p.name ASC";
        break;
    case 'name_desc':
        $order_by = "p.name DESC";
        break;
}

// Re-fetch products with filters
if (!empty($min_price) || !empty($max_price) || $sort !== 'newest') {
    $where_clause = implode(' AND ', $where_conditions);
    $sql = "SELECT p.*, (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 'yes' LIMIT 1) as primary_image
            FROM products p 
            WHERE $where_clause 
            ORDER BY $order_by 
            LIMIT ? OFFSET ?";
    
    $params[] = PRODUCTS_PER_PAGE;
    $params[] = $offset;
    $products = $db->fetchAll($sql, $params);
    
    // Recount total for pagination
    $count_sql = "SELECT COUNT(*) as count FROM products p WHERE $where_clause";
    $count_params = array_slice($params, 0, -2); // Remove limit and offset
    $total_products = $db->fetch($count_sql, $count_params)['count'];
    $total_pages = ceil($total_products / PRODUCTS_PER_PAGE);
}

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<nav class="breadcrumb">
    <div class="container">
        <a href="index.php">Home</a>
        <span>›</span>
        <span><?php echo htmlspecialchars($category['name']); ?></span>
    </div>
</nav>

<!-- Category Header -->
<section class="category-header">
    <div class="container">
        <div class="category-header-content">
            <h1><?php echo htmlspecialchars($category['name']); ?></h1>
            <p><?php echo htmlspecialchars($category['description'] ?? 'Explore our premium collection of ' . $category['name']); ?></p>
        </div>
    </div>
</section>

<!-- Filters and Products -->
<section class="category-content">
    <div class="container">
        <div class="category-layout">
            <!-- Filters Sidebar -->
            <aside class="filters-sidebar">
                <div class="filter-card">
                    <h3>Filters</h3>
                    
                    <!-- Price Filter -->
                    <div class="filter-group">
                        <h4>Price Range</h4>
                        <form method="GET" action="" class="price-filter">
                            <input type="hidden" name="slug" value="<?php echo $slug; ?>">
                            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                            
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
                    <?php if (!empty($min_price) || !empty($max_price) || $sort !== 'newest'): ?>
                        <div class="filter-actions">
                            <a href="?slug=<?php echo $slug; ?>" class="btn btn-secondary btn-sm">Clear All Filters</a>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="products-main">
                <!-- Sorting and Results Count -->
                <div class="products-header">
                    <div class="results-count">
                        <p>Showing <?php echo min($offset + 1, $total_products); ?>-<?php echo min($offset + PRODUCTS_PER_PAGE, $total_products); ?> of <?php echo $total_products; ?> products</p>
                    </div>
                    <div class="sort-options">
                        <form method="GET" action="" class="sort-form">
                            <input type="hidden" name="slug" value="<?php echo $slug; ?>">
                            <?php if (!empty($min_price)): ?>
                                <input type="hidden" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
                            <?php endif; ?>
                            <?php if (!empty($max_price)): ?>
                                <input type="hidden" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
                            <?php endif; ?>
                            
                            <select name="sort" onchange="this.form.submit()">
                                <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                                <option value="price_low" <?php echo $sort === 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                                <option value="price_high" <?php echo $sort === 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                                <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>Name: A to Z</option>
                                <option value="name_desc" <?php echo $sort === 'name_desc' ? 'selected' : ''; ?>>Name: Z to A</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid">
                    <?php if (empty($products)): ?>
                        <div class="no-products">
                            <h3>No products found</h3>
                            <p>Try adjusting your filters or browse our other categories.</p>
                            <a href="products.php" class="btn btn-primary">View All Products</a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <?php if ($product['primary_image']): ?>
                                        <img src="<?php echo SITE_URL; ?>uploads/<?php echo $product['primary_image']; ?>" 
                                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo SITE_URL; ?>assets/images/placeholder-product.jpg" 
                                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <?php endif; ?>
                                    <?php if ($product['discount_price']): ?>
                                        <span class="discount-badge">-<?php echo round((($product['price'] - $product['discount_price']) / $product['price']) * 100); ?>%</span>
                                    <?php endif; ?>
                                    <?php if ($product['featured'] === 'yes'): ?>
                                        <span class="featured-badge">Featured</span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-content">
                                    <h3 class="product-title">
                                        <a href="product.php?slug=<?php echo $product['slug']; ?>">
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        </a>
                                    </h3>
                                    <p class="product-description">
                                        <?php echo truncateText($product['short_description'] ?? $product['description'], 80); ?>
                                    </p>
                                    <div class="product-price">
                                        <?php if ($product['discount_price']): ?>
                                            <span class="current-price"><?php echo formatPrice($product['discount_price']); ?></span>
                                            <span class="original-price"><?php echo formatPrice($product['price']); ?></span>
                                        <?php else: ?>
                                            <span class="current-price"><?php echo formatPrice($product['price']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-actions">
                                        <a href="product.php?slug=<?php echo $product['slug']; ?>" class="btn btn-outline">View Details</a>
                                        <button class="btn btn-primary add-to-cart" data-product-id="<?php echo $product['id']; ?>">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination-wrapper">
                        <?php 
                        $pagination_url = "?slug=$slug";
                        if (!empty($min_price)) $pagination_url .= "&min_price=$min_price";
                        if (!empty($max_price)) $pagination_url .= "&max_price=$max_price";
                        $pagination_url .= "&sort=$sort&page=%d";
                        echo getPagination($page, $total_pages, $pagination_url);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
