<?php
/**
 * All Products Page
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

// Set page meta
$page_title = 'All Products - Divyaghar';
$meta_description = 'Browse our complete collection of high-quality pooja essentials, home décor, god idols, and spiritual gifts at Divyaghar.';
$meta_keywords = 'products, pooja essentials, home decor, god idols, spiritual gifts, divyaghar';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * PRODUCTS_PER_PAGE;

// Get filters
$category_id = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$sort = $_GET['sort'] ?? 'newest';
$search = $_GET['search'] ?? '';

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
    $params[] = $search_param;
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

// Get total products
$where_clause = implode(' AND ', $where_conditions);
$count_sql = "SELECT COUNT(*) as count FROM products p WHERE $where_clause";
$total_products = $db->fetch($count_sql, $params)['count'];
$total_pages = ceil($total_products / PRODUCTS_PER_PAGE);

// Get products
$sql = "SELECT p.*, c.name as category_name, c.slug as category_slug,
        (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 'yes' LIMIT 1) as primary_image
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE $where_clause 
        ORDER BY $order_by 
        LIMIT ? OFFSET ?";

$products_params = array_merge($params, [PRODUCTS_PER_PAGE, $offset]);
$products = $db->fetchAll($sql, $products_params);

// Get categories for filter
$categories = $db->fetchAll("SELECT id, name FROM categories WHERE status = 'active' ORDER BY name ASC");

include 'includes/header.php';
?>

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
            <p>Explore our complete collection of spiritual and home décor items</p>
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
                        <form method="GET" action="" class="search-filter">
                            <input type="text" name="search" placeholder="Search products..." 
                                   value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-outline btn-sm">Search</button>
                        </form>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="filter-group">
                        <h4>Category</h4>
                        <form method="GET" action="" class="category-filter">
                            <?php if (!empty($min_price)): ?>
                                <input type="hidden" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
                            <?php endif; ?>
                            <?php if (!empty($max_price)): ?>
                                <input type="hidden" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
                            <?php endif; ?>
                            <?php if (!empty($search)): ?>
                                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                            <?php endif; ?>
                            <?php if (!empty($sort) && $sort !== 'newest'): ?>
                                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                            <?php endif; ?>
                            
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
                        <form method="GET" action="" class="price-filter">
                            <?php if (!empty($category_id)): ?>
                                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category_id); ?>">
                            <?php endif; ?>
                            <?php if (!empty($search)): ?>
                                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                            <?php endif; ?>
                            <?php if (!empty($sort) && $sort !== 'newest'): ?>
                                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                            <?php endif; ?>
                            
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
                    <?php if (!empty($category_id) || !empty($min_price) || !empty($max_price) || !empty($search) || $sort !== 'newest'): ?>
                        <div class="filter-actions">
                            <a href="products.php" class="btn btn-secondary btn-sm">Clear All Filters</a>
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
                            <?php if (!empty($category_id)): ?>
                                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category_id); ?>">
                            <?php endif; ?>
                            <?php if (!empty($min_price)): ?>
                                <input type="hidden" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
                            <?php endif; ?>
                            <?php if (!empty($max_price)): ?>
                                <input type="hidden" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
                            <?php endif; ?>
                            <?php if (!empty($search)): ?>
                                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
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
                            <p>Try adjusting your filters or browse our categories.</p>
                            <a href="products.php" class="btn btn-primary">Clear Filters</a>
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
                                    <div class="product-category">
                                        <a href="category.php?slug=<?php echo $product['category_slug']; ?>">
                                            <?php echo htmlspecialchars($product['category_name']); ?>
                                        </a>
                                    </div>
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
                        $pagination_url = "?";
                        $query_params = [];
                        if (!empty($category_id)) $query_params[] = "category=$category_id";
                        if (!empty($min_price)) $query_params[] = "min_price=$min_price";
                        if (!empty($max_price)) $query_params[] = "max_price=$max_price";
                        if (!empty($search)) $query_params[] = "search=" . urlencode($search);
                        $query_params[] = "sort=$sort";
                        $pagination_url .= implode("&", $query_params) . "&page=%d";
                        echo getPagination($page, $total_pages, $pagination_url);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
