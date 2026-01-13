<?php
/**
 * Search Results Page
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

// Get search query
$query = $_GET['q'] ?? '';

if (empty($query)) {
    redirect('index.php');
}

// Set page meta
$page_title = 'Search Results for "' . htmlspecialchars($query) . '" - Divyaghar';
$meta_description = 'Search results for "' . htmlspecialchars($query) . '" at Divyaghar. Find spiritual items, pooja essentials, and home décor.';
$meta_keywords = htmlspecialchars($query) . ', search, divyaghar, spiritual items';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * PRODUCTS_PER_PAGE;

// Get filters
$category_id = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$sort = $_GET['sort'] ?? 'relevance';

// Build search query
$where_conditions = ["p.status = 'active'", "(p.name LIKE ? OR p.description LIKE ? OR p.short_description LIKE ?)"];
$params = ['%' . $query . '%', '%' . $query . '%', '%' . $query . '%'];

if (!empty($category_id)) {
    $where_conditions[] = "p.category_id = ?";
    $params[] = (int)$category_id;
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
$order_by = "CASE WHEN p.name LIKE ? THEN 1 WHEN p.name LIKE ? THEN 2 ELSE 3 END, p.featured = 'yes' DESC, p.created_at DESC";
array_unshift($params, $query . '%', '%' . $query . '%');

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

// Get total results
$where_clause = implode(' AND ', $where_conditions);
$count_sql = "SELECT COUNT(*) as count FROM products p WHERE $where_clause";
$total_products = $db->fetch($count_sql, $params)['count'];
$total_pages = ceil($total_products / PRODUCTS_PER_PAGE);

// Get search results
$sql = "SELECT p.*, c.name as category_name, c.slug as category_slug,
        (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 'yes' LIMIT 1) as primary_image
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE $where_clause 
        ORDER BY $order_by 
        LIMIT ? OFFSET ?";

$search_params = array_merge($params, [PRODUCTS_PER_PAGE, $offset]);
$products = $db->fetchAll($sql, $search_params);

// Get categories for filter
$categories = $db->fetchAll("SELECT id, name FROM categories WHERE status = 'active' ORDER BY name ASC");

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<nav class="breadcrumb">
    <div class="container">
        <a href="index.php">Home</a>
        <span>›</span>
        <span>Search Results</span>
    </div>
</nav>

<!-- Search Header -->
<section class="search-header">
    <div class="container">
        <div class="search-header-content">
            <h1>Search Results</h1>
            <p class="search-query">
                Showing results for "<strong><?php echo htmlspecialchars($query); ?></strong>"
            </p>
            <p class="results-count">
                Found <?php echo $total_products; ?> product<?php echo $total_products !== 1 ? 's' : ''; ?>
            </p>
        </div>
    </div>
</section>

<!-- Search Results Section -->
<section class="search-results">
    <div class="container">
        <div class="search-layout">
            <!-- Filters Sidebar -->
            <aside class="filters-sidebar">
                <div class="filter-card">
                    <h3>Filters</h3>
                    
                    <!-- Search Form -->
                    <div class="filter-group">
                        <h4>Search Again</h4>
                        <form method="GET" action="search.php" class="search-filter">
                            <input type="text" name="q" placeholder="Search products..." 
                                   value="<?php echo htmlspecialchars($query); ?>">
                            <button type="submit" class="btn btn-outline btn-sm">Search</button>
                        </form>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="filter-group">
                        <h4>Category</h4>
                        <form method="GET" action="" class="category-filter">
                            <input type="hidden" name="q" value="<?php echo htmlspecialchars($query); ?>">
                            <?php if (!empty($min_price)): ?>
                                <input type="hidden" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
                            <?php endif; ?>
                            <?php if (!empty($max_price)): ?>
                                <input type="hidden" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
                            <?php endif; ?>
                            <?php if (!empty($sort) && $sort !== 'relevance'): ?>
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
                            <input type="hidden" name="q" value="<?php echo htmlspecialchars($query); ?>">
                            <?php if (!empty($category_id)): ?>
                                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category_id); ?>">
                            <?php endif; ?>
                            <?php if (!empty($sort) && $sort !== 'relevance'): ?>
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
                    <?php if (!empty($category_id) || !empty($min_price) || !empty($max_price) || $sort !== 'relevance'): ?>
                        <div class="filter-actions">
                            <a href="?q=<?php echo urlencode($query); ?>" class="btn btn-secondary btn-sm">Clear Filters</a>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>

            <!-- Search Results -->
            <div class="search-main">
                <!-- Sorting and Results Count -->
                <div class="search-results-header">
                    <div class="results-count">
                        <p>Showing <?php echo min($offset + 1, $total_products); ?>-<?php echo min($offset + PRODUCTS_PER_PAGE, $total_products); ?> of <?php echo $total_products; ?> results</p>
                    </div>
                    <div class="sort-options">
                        <form method="GET" action="" class="sort-form">
                            <input type="hidden" name="q" value="<?php echo htmlspecialchars($query); ?>">
                            <?php if (!empty($category_id)): ?>
                                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category_id); ?>">
                            <?php endif; ?>
                            <?php if (!empty($min_price)): ?>
                                <input type="hidden" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
                            <?php endif; ?>
                            <?php if (!empty($max_price)): ?>
                                <input type="hidden" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
                            <?php endif; ?>
                            
                            <select name="sort" onchange="this.form.submit()">
                                <option value="relevance" <?php echo $sort === 'relevance' ? 'selected' : ''; ?>>Most Relevant</option>
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
                        <div class="no-results">
                            <div class="no-results-icon">🔍</div>
                            <h3>No results found</h3>
                            <p>We couldn't find any products matching "<?php echo htmlspecialchars($query); ?>"</p>
                            <div class="search-suggestions">
                                <h4>Suggestions:</h4>
                                <ul>
                                    <li>Check your spelling</li>
                                    <li>Try more general keywords</li>
                                    <li>Browse our categories</li>
                                    <li>Contact us for help finding what you need</li>
                                </ul>
                            </div>
                            <div class="search-actions">
                                <a href="products.php" class="btn btn-primary">Browse All Products</a>
                                <a href="contact.php" class="btn btn-outline">Contact Support</a>
                            </div>
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
                                            <?php 
                                            // Highlight search term in product name
                                            $highlighted_name = htmlspecialchars($product['name']);
                                            if (!empty($query)) {
                                                $highlighted_name = preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', $highlighted_name);
                                            }
                                            echo $highlighted_name;
                                            ?>
                                        </a>
                                    </h3>
                                    <p class="product-description">
                                        <?php 
                                        // Highlight search term in description
                                        $description = truncateText($product['short_description'] ?? $product['description'], 80);
                                        if (!empty($query)) {
                                            $description = preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', $description);
                                        }
                                        echo $description;
                                        ?>
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
                        $pagination_url = "?q=" . urlencode($query);
                        if (!empty($category_id)) $pagination_url .= "&category=$category_id";
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

<!-- Popular Searches Section -->
<section class="popular-searches">
    <div class="container">
        <div class="section-header">
            <h2>Popular Searches</h2>
            <p>Explore what other customers are looking for</p>
        </div>
        <div class="popular-tags">
            <a href="search.php?q=ganesh idol" class="tag">Ganesh Idol</a>
            <a href="search.php?q=brass diya" class="tag">Brass Diya</a>
            <a href="search.php?q=pooja thali" class="tag">Pooja Thali</a>
            <a href="search.php?q=incense sticks" class="tag">Incense Sticks</a>
            <a href="search.php?q=shivling" class="tag">Shivling</a>
            <a href="search.php?q=radha krishna" class="tag">Radha Krishna</a>
            <a href="search.php?q=home decor" class="tag">Home Decor</a>
            <a href="search.php?q=spiritual gifts" class="tag">Spiritual Gifts</a>
            <a href="search.php?q=wall hanging" class="tag">Wall Hanging</a>
            <a href="search.php?q=bell" class="tag">Bell</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
