<?php
/**
 * All Products Page - Premium Design
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

<!-- Enhanced Products JavaScript -->
<script src="<?php echo SITE_URL; ?>assets/js/enhanced-products.js?v=<?php echo time(); ?>" defer></script>

<!-- Products Hero Section -->
<section class="products-hero-section">
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">Discover Divine Products</h1>
            <p class="hero-subtitle">Explore our complete collection of spiritual essentials and sacred items</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format($total_products); ?></span>
                    <span class="stat-label">Products</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($categories); ?></span>
                    <span class="stat-label">Categories</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">Authentic</span>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-image-wrapper">
                <img src="<?php echo SITE_URL; ?>assets/images/hero-image.svg" alt="Divyaghar Products">
                <div class="hero-badge">Premium Collection</div>
            </div>
        </div>
    </div>
</section>

<!-- Filters and Products -->
<section class="products-content-section">
    <div class="container">
        <div class="products-layout">
            <!-- Enhanced Filters Sidebar -->
            <aside class="filters-sidebar">
                <div class="filter-card">
                    <div class="filter-header">
                        <h3>🔍 Filters</h3>
                        <button class="filter-toggle" onclick="toggleFilters()">
                            <span class="toggle-icon">−</span>
                        </button>
                    </div>
                    
                    <!-- Quick Filters - Always Visible -->
                    <div class="quick-filters">
                        <h4>⚡ Quick Filters</h4>
                        <div class="quick-filter-tags">
                            <button class="quick-filter-tag" onclick="applyQuickFilter('featured')">⭐ Featured</button>
                            <button class="quick-filter-tag" onclick="applyQuickFilter('new')">🆕 New Arrivals</button>
                            <button class="quick-filter-tag" onclick="applyQuickFilter('sale')">💰 On Sale</button>
                            <button class="quick-filter-tag" onclick="applyQuickFilter('instock')">✅ In Stock</button>
                            <button class="quick-filter-tag" onclick="applyQuickFilter('under500')">Under ₹500</button>
                            <button class="quick-filter-tag" onclick="applyQuickFilter('freeship')">🚚 Free Ship</button>
                        </div>
                    </div>
                    
                    <!-- Active Filters Display -->
                    <?php if (!empty($category_id) || !empty($min_price) || !empty($max_price) || !empty($search) || $sort !== 'newest'): ?>
                        <div class="active-filters">
                            <h4>🏷️ Active Filters:</h4>
                            <div class="active-filter-tags">
                                <?php if (!empty($search)): ?>
                                    <span class="filter-tag">
                                        Search: <?php echo htmlspecialchars($search); ?>
                                        <a href="?<?php echo buildQueryString(['search' => null]); ?>">×</a>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($category_id)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <?php if ($cat['id'] == $category_id): ?>
                                            <span class="filter-tag">
                                                <?php echo htmlspecialchars($cat['name']); ?>
                                                <a href="?<?php echo buildQueryString(['category' => null]); ?>">×</a>
                                            </span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if (!empty($min_price)): ?>
                                    <span class="filter-tag">
                                        Min: ₹<?php echo htmlspecialchars($min_price); ?>
                                        <a href="?<?php echo buildQueryString(['min_price' => null]); ?>">×</a>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($max_price)): ?>
                                    <span class="filter-tag">
                                        Max: ₹<?php echo htmlspecialchars($max_price); ?>
                                        <a href="?<?php echo buildQueryString(['max_price' => null]); ?>">×</a>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Advanced Filters Toggle -->
                    <div class="advanced-filters-toggle" onclick="toggleAdvancedFilters()">
                        ⚙️ Advanced Filters
                    </div>
                    
                    <!-- Advanced Filters Content -->
                    <div class="filter-content" id="advancedFilters">
                        <!-- Search -->
                        <div class="filter-group">
                            <h4>🔍 Search Products</h4>
                            <form method="GET" action="" class="search-filter">
                                <?php if (!empty($category_id)): ?>
                                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category_id); ?>">
                                <?php endif; ?>
                                <?php if (!empty($min_price)): ?>
                                    <input type="hidden" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
                                <?php endif; ?>
                                <?php if (!empty($max_price)): ?>
                                    <input type="hidden" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
                                <?php endif; ?>
                                <?php if (!empty($sort) && $sort !== 'newest'): ?>
                                    <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                                <?php endif; ?>
                                
                                <div class="search-wrapper">
                                    <input type="text" name="search" placeholder="Search..." 
                                           value="<?php echo htmlspecialchars($search); ?>" class="search-input">
                                    <button type="submit" class="search-btn">🔍</button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="filter-group">
                            <h4>🙏 Categories</h4>
                            <div class="category-list">
                                <?php foreach ($categories as $cat): ?>
                                    <label class="category-item">
                                        <input type="checkbox" name="categories[]" value="<?php echo $cat['id']; ?>"
                                               <?php echo ($category_id == $cat['id']) ? 'checked' : ''; ?>
                                               onchange="updateCategoryFilter(this)">
                                        <span class="category-label">
                                            <span class="category-icon">🙏</span>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </span>
                                        <span class="category-count">(<?php echo rand(10, 100); ?>)</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Price Range Filter -->
                        <div class="filter-group">
                            <h4>💰 Price Range</h4>
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
                                
                                <div class="price-range-slider">
                                    <div class="slider-track">
                                        <div class="slider-range"></div>
                                    </div>
                                    <div class="slider-thumb" data-type="min"></div>
                                    <div class="slider-thumb" data-type="max"></div>
                                </div>
                                
                                <div class="price-inputs">
                                    <input type="number" name="min_price" placeholder="Min" 
                                           value="<?php echo htmlspecialchars($min_price); ?>" min="0" class="price-input" id="minPrice">
                                    <span class="price-separator">−</span>
                                    <input type="number" name="max_price" placeholder="Max" 
                                           value="<?php echo htmlspecialchars($max_price); ?>" min="0" class="price-input" id="maxPrice">
                                </div>
                                
                                <div class="price-presets">
                                    <button type="button" class="preset-btn" onclick="setPriceRange(0, 500)">Under ₹500</button>
                                    <button type="button" class="preset-btn" onclick="setPriceRange(500, 2000)">₹500-₹2000</button>
                                    <button type="button" class="preset-btn" onclick="setPriceRange(2000, 5000)">₹2000-₹5000</button>
                                    <button type="button" class="preset-btn" onclick="setPriceRange(5000, 99999)">Above ₹5000</button>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-sm">Apply Price Filter</button>
                            </form>
                        </div>
                        
                        <!-- Brand Filter -->
                        <div class="filter-group">
                            <h4>🏷️ Brands</h4>
                            <div class="brand-list">
                                <label class="brand-item">
                                    <input type="checkbox" name="brands[]" value="divine">
                                    <span class="brand-name">Divine Collection</span>
                                    <span class="brand-count">(<?php echo rand(20, 80); ?>)</span>
                                </label>
                                <label class="brand-item">
                                    <input type="checkbox" name="brands[]" value="traditional">
                                    <span class="brand-name">Traditional Arts</span>
                                    <span class="brand-count">(<?php echo rand(15, 60); ?>)</span>
                                </label>
                                <label class="brand-item">
                                    <input type="checkbox" name="brands[]" value="spiritual">
                                    <span class="brand-name">Spiritual Store</span>
                                    <span class="brand-count">(<?php echo rand(10, 45); ?>)</span>
                                </label>
                                <label class="brand-item">
                                    <input type="checkbox" name="brands[]" value="premium">
                                    <span class="brand-name">Premium Crafts</span>
                                    <span class="brand-count">(<?php echo rand(25, 70); ?>)</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Rating Filter -->
                        <div class="filter-group">
                            <h4>⭐ Customer Rating</h4>
                            <div class="rating-filter">
                                <label class="rating-item">
                                    <input type="radio" name="rating" value="4" onchange="this.form.submit()">
                                    <span class="rating-stars">⭐⭐⭐⭐</span>
                                    <span class="rating-text">4 Stars & Up</span>
                                </label>
                                <label class="rating-item">
                                    <input type="radio" name="rating" value="3" onchange="this.form.submit()">
                                    <span class="rating-stars">⭐⭐⭐</span>
                                    <span class="rating-text">3 Stars & Up</span>
                                </label>
                                <label class="rating-item">
                                    <input type="radio" name="rating" value="2" onchange="this.form.submit()">
                                    <span class="rating-stars">⭐⭐</span>
                                    <span class="rating-text">2 Stars & Up</span>
                                </label>
                                <label class="rating-item">
                                    <input type="radio" name="rating" value="1" onchange="this.form.submit()">
                                    <span class="rating-stars">⭐</span>
                                    <span class="rating-text">1 Star & Up</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Availability Filter -->
                        <div class="filter-group">
                            <h4>📦 Availability</h4>
                            <div class="availability-filter">
                                <label class="availability-item">
                                    <input type="checkbox" name="in_stock" value="1" onchange="this.form.submit()">
                                    <span class="availability-text">In Stock Only</span>
                                </label>
                                <label class="availability-item">
                                    <input type="checkbox" name="free_shipping" value="1" onchange="this.form.submit()">
                                    <span class="availability-text">Free Shipping</span>
                                </label>
                                <label class="availability-item">
                                    <input type="checkbox" name="discount" value="1" onchange="this.form.submit()">
                                    <span class="availability-text">On Sale</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Clear Filters -->
                        <div class="filter-actions">
                            <a href="products.php" class="btn btn-secondary btn-sm">🔄 Clear All</a>
                            <button class="btn btn-primary btn-sm" onclick="applyAllFilters()">Apply Filters</button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Products Main -->
            <div class="products-main">
                <!-- Sorting and Results Count -->
                <div class="products-header">
                    <div class="results-info">
                        <span class="results-count">
                            Showing <strong><?php echo min($offset + 1, $total_products); ?>-<?php echo min($offset + PRODUCTS_PER_PAGE, $total_products); ?></strong> 
                            of <strong><?php echo $total_products; ?></strong> products
                        </span>
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
                            
                            <select name="sort" onchange="this.form.submit()" class="sort-select">
                                <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>🆕 Newest First</option>
                                <option value="price_low" <?php echo $sort === 'price_low' ? 'selected' : ''; ?>>💰 Price: Low to High</option>
                                <option value="price_high" <?php echo $sort === 'price_high' ? 'selected' : ''; ?>>💰 Price: High to Low</option>
                                <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>🔤 Name: A to Z</option>
                                <option value="name_desc" <?php echo $sort === 'name_desc' ? 'selected' : ''; ?>>🔤 Name: Z to A</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid">
                    <?php if (empty($products)): ?>
                        <div class="no-products">
                            <div class="no-products-icon">🙏</div>
                            <h3>No Products Found</h3>
                            <p>Try adjusting your filters or browse our categories to find what you're looking for.</p>
                            <div class="no-products-actions">
                                <a href="products.php" class="btn btn-primary">Clear Filters</a>
                                <a href="index.php" class="btn btn-outline">Back to Home</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card enhanced-product-card" data-product-id="<?php echo $product['id']; ?>">
                                <div class="product-image-wrapper">
                                    <img src="<?php echo getProductImage($product['primary_image']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                         class="product-image"
                                         loading="lazy">
                                    
                                    <!-- Enhanced Product Badges -->
                                    <div class="product-badges">
                                        <?php if ($product['featured'] === 'yes'): ?>
                                            <span class="product-badge badge-featured">
                                                <i class="fas fa-star"></i> Featured
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($product['discount_price']): ?>
                                            <span class="product-badge badge-sale">
                                                <i class="fas fa-percentage"></i> 
                                                -<?php echo round((($product['price'] - $product['discount_price']) / $product['price']) * 100); ?>%
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($product['stock_quantity'] <= 0): ?>
                                            <span class="product-badge badge-out-of-stock">
                                                <i class="fas fa-times-circle"></i> Out of Stock
                                            </span>
                                        <?php elseif ($product['stock_quantity'] < 10): ?>
                                            <span class="product-badge badge-low-stock">
                                                <i class="fas fa-exclamation-triangle"></i> Low Stock
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Stock Status Indicator -->
                                    <div class="stock-indicator <?php 
                                        echo $product['stock_quantity'] > 0 ? 'in-stock' : 'out-of-stock'; 
                                        echo ($product['stock_quantity'] > 0 && $product['stock_quantity'] < 10) ? ' low-stock' : ''; 
                                    ?>">
                                        <?php if ($product['stock_quantity'] > 0): ?>
                                            <i class="fas fa-check-circle"></i>
                                            <span><?php echo $product['stock_quantity'] < 10 ? 'Only ' . $product['stock_quantity'] . ' left' : 'In Stock'; ?></span>
                                        <?php else: ?>
                                            <i class="fas fa-times-circle"></i>
                                            <span>Out of Stock</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Quick Actions Overlay -->
                                    <div class="product-overlay">
                                        <div class="quick-actions">
                                            <button class="quick-view-btn" data-product-id="<?php echo $product['id']; ?>" title="Quick View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="compare-btn" data-product-id="<?php echo $product['id']; ?>" title="Compare">
                                                <i class="fas fa-balance-scale"></i>
                                            </button>
                                            <button class="share-btn" data-product-id="<?php echo $product['id']; ?>" title="Share">
                                                <i class="fas fa-share-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="product-details">
                                    <!-- Product Category -->
                                    <div class="product-category">
                                        <a href="category.php?slug=<?php echo $product['category_slug']; ?>">
                                            <?php echo htmlspecialchars($product['category_name']); ?>
                                        </a>
                                    </div>
                                    
                                    <!-- Product Title -->
                                    <h3 class="product-title">
                                        <a href="product.php?slug=<?php echo $product['slug']; ?>">
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        </a>
                                    </h3>
                                    
                                    <!-- Enhanced Rating Display -->
                                    <div class="product-rating">
                                        <div class="stars">
                                            <?php 
                                            $rating = rand(4, 5);
                                            for ($i = 1; $i <= 5; $i++) {
                                                $filled = $i <= $rating ? 'filled' : '';
                                                echo '<i class="fas fa-star ' . $filled . '"></i>';
                                            }
                                            ?>
                                        </div>
                                        <span class="rating-count">(<?php echo rand(50, 500); ?>)</span>
                                    </div>
                                    
                                    <!-- Enhanced Price Display -->
                                    <div class="product-price">
                                        <?php if ($product['discount_price']): ?>
                                            <span class="price-current"><?php echo formatPrice($product['discount_price']); ?></span>
                                            <span class="price-original"><?php echo formatPrice($product['price']); ?></span>
                                            <span class="price-save">Save <?php echo formatPrice($product['price'] - $product['discount_price']); ?></span>
                                        <?php else: ?>
                                            <span class="price-current"><?php echo formatPrice($product['price']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Product Description -->
                                    <p class="product-description">
                                        <?php echo truncateText($product['short_description'] ?? $product['description'], 100); ?>
                                    </p>
                                    
                                    <!-- Product Meta Information -->
                                    <div class="product-meta">
                                        <div class="shipping-info">
                                            <i class="fas fa-truck"></i>
                                            <span>Free Shipping</span>
                                        </div>
                                        <?php if ($product['stock_quantity'] > 0): ?>
                                            <div class="delivery-info">
                                                <i class="fas fa-clock"></i>
                                                <span>5-7 days delivery</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Enhanced Action Buttons -->
                                    <div class="product-actions">
                                        <button class="btn btn-primary add-to-cart-btn" 
                                                data-product-id="<?php echo $product['id']; ?>"
                                                data-product-name="<?php echo htmlspecialchars($product['name']); ?>"
                                                data-product-price="<?php echo $product['discount_price'] ?: $product['price']; ?>"
                                                <?php echo ($product['stock_quantity'] <= 0) ? 'disabled' : ''; ?>>
                                            <?php if ($product['stock_quantity'] <= 0): ?>
                                                <i class="fas fa-times"></i> Out of Stock
                                            <?php else: ?>
                                                <i class="fas fa-shopping-cart"></i> Add to Cart
                                            <?php endif; ?>
                                        </button>
                                        
                                        <div class="secondary-actions">
                                            <button class="btn btn-outline wishlist-btn" 
                                                    data-product-id="<?php echo $product['id']; ?>"
                                                    title="Add to Wishlist">
                                                <i class="far fa-heart"></i>
                                            </button>
                                            <button class="btn btn-outline view-details-btn" 
                                                    onclick="window.location.href='product.php?slug=<?php echo $product['slug']; ?>'"
                                                    title="View Details">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Quick View Modal -->
                <div id="quickViewModal" class="quick-view-modal">
                    <div class="quick-view-content">
                        <button class="close-modal">&times;</button>
                        <div class="quick-view-body">
                            <div class="quick-view-image">
                                <img id="quickViewImage" src="" alt="">
                            </div>
                            <div class="quick-view-details">
                                <h3 id="quickViewTitle"></h3>
                                <div class="quick-view-rating">
                                    <div class="stars" id="quickViewRating"></div>
                                    <span id="quickViewReviews"></span>
                                </div>
                                <div class="quick-view-price" id="quickViewPrice"></div>
                                <p id="quickViewDescription"></p>
                                <div class="quick-view-actions">
                                    <button class="btn btn-primary" id="quickViewAddToCart">🛒 Add to Cart</button>
                                    <button class="btn btn-outline" id="quickViewWishlist">❤️ Wishlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
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

<script>
// Compact Filter Functions
function toggleAdvancedFilters() {
    const advancedFilters = document.getElementById('advancedFilters');
    const toggleBtn = document.querySelector('.advanced-filters-toggle');
    
    if (advancedFilters.classList.contains('expanded')) {
        advancedFilters.classList.remove('expanded');
        advancedFilters.classList.add('collapsed');
        toggleBtn.innerHTML = '⚙️ Advanced Filters';
    } else {
        advancedFilters.classList.remove('collapsed');
        advancedFilters.classList.add('expanded');
        toggleBtn.innerHTML = '⚙️ Hide Advanced Filters';
    }
}

function toggleFilters() {
    const filterContent = document.querySelector('.filter-content');
    const toggleIcon = document.querySelector('.toggle-icon');
    
    if (filterContent.classList.contains('collapsed')) {
        filterContent.classList.remove('collapsed');
        toggleIcon.textContent = '−';
    } else {
        filterContent.classList.add('collapsed');
        toggleIcon.textContent = '+';
    }
}

function applyQuickFilter(filterType) {
    const url = new URL(window.location);
    
    // Clear existing filters first
    url.searchParams.delete('search');
    url.searchParams.delete('category');
    url.searchParams.delete('min_price');
    url.searchParams.delete('max_price');
    url.searchParams.delete('brands');
    url.searchParams.delete('rating');
    url.searchParams.delete('in_stock');
    url.searchParams.delete('free_shipping');
    url.searchParams.delete('discount');
    
    // Apply quick filter
    switch(filterType) {
        case 'featured':
            url.searchParams.set('featured', '1');
            break;
        case 'new':
            url.searchParams.set('new', '1');
            break;
        case 'sale':
            url.searchParams.set('discount', '1');
            break;
        case 'instock':
            url.searchParams.set('in_stock', '1');
            break;
        case 'under500':
            url.searchParams.set('max_price', '500');
            break;
        case 'freeship':
            url.searchParams.set('free_shipping', '1');
            break;
    }
    
    window.location.href = url.toString();
}

function buildQueryString(params) {
    const url = new URL(window.location);
    
    Object.keys(params).forEach(key => {
        if (params[key] === null) {
            url.searchParams.delete(key);
        } else {
            url.searchParams.set(key, params[key]);
        }
    });
    
    return url.search.substring(1);
}

function updateCategoryFilter(checkbox) {
    const url = new URL(window.location);
    
    if (checkbox.checked) {
        url.searchParams.set('category', checkbox.value);
    } else {
        url.searchParams.delete('category');
    }
    
    window.location.href = url.toString();
}

function setPriceRange(min, max) {
    const url = new URL(window.location);
    url.searchParams.set('min_price', min);
    url.searchParams.set('max_price', max);
    window.location.href = url.toString();
}

function applyAllFilters() {
    // Collect all filter values and submit
    const form = document.querySelector('.price-filter');
    if (form) {
        form.submit();
    }
}

// Initialize compact filter state
document.addEventListener('DOMContentLoaded', function() {
    // Hide advanced filters by default
    const advancedFilters = document.getElementById('advancedFilters');
    if (advancedFilters) {
        advancedFilters.classList.add('collapsed');
        advancedFilters.classList.remove('expanded');
    }
    
    // Add active state to quick filters based on current URL
    const urlParams = new URLSearchParams(window.location.search);
    const quickFilterTags = document.querySelectorAll('.quick-filter-tag');
    
    quickFilterTags.forEach(tag => {
        const filterType = tag.getAttribute('onclick').match(/'([^']+)'/)[1];
        
        let isActive = false;
        switch(filterType) {
            case 'featured':
                isActive = urlParams.get('featured') === '1';
                break;
            case 'new':
                isActive = urlParams.get('new') === '1';
                break;
            case 'sale':
                isActive = urlParams.get('discount') === '1';
                break;
            case 'instock':
                isActive = urlParams.get('in_stock') === '1';
                break;
            case 'under500':
                isActive = urlParams.get('max_price') === '500';
                break;
            case 'freeship':
                isActive = urlParams.get('free_shipping') === '1';
                break;
        }
        
        if (isActive) {
            tag.classList.add('active');
        }
    });
});
</script>
