<?php
/**
 * Product Detail Page
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

// Get product slug from URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    redirect('index.php');
}

// Get product details
$product = $db->fetch("SELECT p.*, c.name as category_name, c.slug as category_slug 
                       FROM products p 
                       LEFT JOIN categories c ON p.category_id = c.id 
                       WHERE p.slug = ? AND p.status = 'active'", [$slug]);

if (!$product) {
    setFlashMessage('error', 'Product not found');
    redirect('index.php');
}

// Get product images
$images = $db->fetchAll("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC", [$product['id']]);

// Get related products (same category)
$related_products = $db->fetchAll("SELECT p.*, (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 'yes' LIMIT 1) as primary_image
                                   FROM products p 
                                   WHERE p.category_id = ? AND p.id != ? AND p.status = 'active' 
                                   ORDER BY RAND() LIMIT 4", [$product['category_id'], $product['id']]);

// Set page meta
$page_title = $product['meta_title'] ?? $product['name'] . ' - Divyaghar';
$meta_description = $product['meta_description'] ?? $product['short_description'] ?? truncateText($product['description'], 160);
$meta_keywords = $product['name'] . ', ' . $product['category_name'] . ', spiritual items, divyaghar, pooja essentials';

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<nav class="breadcrumb">
    <div class="container">
        <a href="index.php">Home</a>
        <span>›</span>
        <a href="category.php?slug=<?php echo $product['category_slug']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a>
        <span>›</span>
        <span><?php echo htmlspecialchars($product['name']); ?></span>
    </div>
</nav>

<!-- Product Detail Section -->
<section class="product-detail">
    <div class="container">
        <div class="product-detail-layout">
            <!-- Product Images -->
            <div class="product-images">
                <div class="main-image">
                    <?php if (!empty($images)): ?>
                        <img id="mainProductImage" 
                             src="<?php echo SITE_URL; ?>uploads/<?php echo $images[0]['image_path']; ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <img id="mainProductImage" 
                             src="<?php echo SITE_URL; ?>assets/images/placeholder-product.jpg" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php endif; ?>
                </div>
                
                <?php if (count($images) > 1): ?>
                    <div class="thumbnail-images">
                        <?php foreach ($images as $index => $image): ?>
                            <img src="<?php echo SITE_URL; ?>uploads/<?php echo $image['image_path']; ?>" 
                                 alt="<?php echo htmlspecialchars($image['alt_text'] ?? $product['name']); ?>"
                                 class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>"
                                 onclick="changeMainImage('<?php echo SITE_URL; ?>uploads/<?php echo $image['image_path']; ?>', this)">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Information -->
            <div class="product-info">
                <div class="product-category">
                    <a href="category.php?slug=<?php echo $product['category_slug']; ?>">
                        <?php echo htmlspecialchars($product['category_name']); ?>
                    </a>
                </div>
                
                <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="product-price">
                    <?php if ($product['discount_price']): ?>
                        <span class="current-price"><?php echo formatPrice($product['discount_price']); ?></span>
                        <span class="original-price"><?php echo formatPrice($product['price']); ?></span>
                        <span class="discount-percent">
                            Save <?php echo round((($product['price'] - $product['discount_price']) / $product['price']) * 100); ?>%
                        </span>
                    <?php else: ?>
                        <span class="current-price"><?php echo formatPrice($product['price']); ?></span>
                    <?php endif; ?>
                </div>

                <?php if ($product['stock_quantity'] > 0): ?>
                    <div class="stock-info">
                        <span class="in-stock">✓ In Stock (<?php echo $product['stock_quantity']; ?> available)</span>
                    </div>
                <?php else: ?>
                    <div class="stock-info">
                        <span class="out-stock">✗ Out of Stock</span>
                    </div>
                <?php endif; ?>

                <div class="product-description">
                    <?php if (!empty($product['short_description'])): ?>
                        <p><?php echo htmlspecialchars($product['short_description']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="product-details">
                    <?php if (!empty($product['sku'])): ?>
                        <div class="detail-item">
                            <span class="label">SKU:</span>
                            <span class="value"><?php echo htmlspecialchars($product['sku']); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($product['weight'])): ?>
                        <div class="detail-item">
                            <span class="label">Weight:</span>
                            <span class="value"><?php echo $product['weight']; ?> kg</span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($product['dimensions'])): ?>
                        <div class="detail-item">
                            <span class="label">Dimensions:</span>
                            <span class="value"><?php echo htmlspecialchars($product['dimensions']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="purchase-actions">
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn decrease">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>">
                            <button type="button" class="quantity-btn increase">+</button>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="btn btn-primary add-to-cart-btn" 
                                data-product-id="<?php echo $product['id']; ?>"
                                <?php echo $product['stock_quantity'] <= 0 ? 'disabled' : ''; ?>>
                            <?php echo $product['stock_quantity'] <= 0 ? 'Out of Stock' : 'Add to Cart'; ?>
                        </button>
                        
                        <a href="cart.php" class="btn btn-outline">View Cart</a>
                    </div>
                </div>

                <div class="product-features">
                    <div class="feature-item">
                        <span class="feature-icon">🏆</span>
                        <span>Premium Quality</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🚚</span>
                        <span>Free Shipping</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✨</span>
                        <span>Authentic Product</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🔄</span>
                        <span>Easy Returns</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Description Section -->
<section class="product-description-section">
    <div class="container">
        <div class="description-tabs">
            <div class="tab-buttons">
                <button class="tab-btn active" data-tab="description">Description</button>
                <button class="tab-btn" data-tab="details">Details</button>
                <button class="tab-btn" data-tab="shipping">Shipping</button>
            </div>
            
            <div class="tab-content">
                <div id="description" class="tab-pane active">
                    <div class="description-content">
                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                    </div>
                </div>
                
                <div id="details" class="tab-pane">
                    <div class="details-grid">
                        <div class="detail-row">
                            <span class="label">Product Name:</span>
                            <span class="value"><?php echo htmlspecialchars($product['name']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Category:</span>
                            <span class="value"><?php echo htmlspecialchars($product['category_name']); ?></span>
                        </div>
                        <?php if (!empty($product['sku'])): ?>
                            <div class="detail-row">
                                <span class="label">SKU:</span>
                                <span class="value"><?php echo htmlspecialchars($product['sku']); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="detail-row">
                            <span class="label">Price:</span>
                            <span class="value"><?php echo formatPrice($product['discount_price'] ?: $product['price']); ?></span>
                        </div>
                        <?php if (!empty($product['weight'])): ?>
                            <div class="detail-row">
                                <span class="label">Weight:</span>
                                <span class="value"><?php echo $product['weight']; ?> kg</span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($product['dimensions'])): ?>
                            <div class="detail-row">
                                <span class="label">Dimensions:</span>
                                <span class="value"><?php echo htmlspecialchars($product['dimensions']); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="detail-row">
                            <span class="label">Availability:</span>
                            <span class="value"><?php echo $product['stock_quantity'] > 0 ? 'In Stock' : 'Out of Stock'; ?></span>
                        </div>
                    </div>
                </div>
                
                <div id="shipping" class="tab-pane">
                    <div class="shipping-content">
                        <h4>Shipping Information</h4>
                        <ul>
                            <li>Free shipping on orders above ₹999</li>
                            <li>Standard delivery: 5-7 business days</li>
                            <li>Express delivery: 2-3 business days</li>
                            <li>Cash on delivery available</li>
                            <li>Secure packaging to prevent damage</li>
                            <li>Tracking provided for all orders</li>
                        </ul>
                        
                        <h4>Return Policy</h4>
                        <ul>
                            <li>7-day return policy</li>
                            <li>Product must be unused and in original packaging</li>
                            <li>Refund processed within 5-7 business days</li>
                            <li>Customer responsible for return shipping costs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products Section -->
<?php if (!empty($related_products)): ?>
<section class="related-products">
    <div class="container">
        <div class="section-header">
            <h2>Related Products</h2>
            <p>You might also like these spiritual items</p>
        </div>
        <div class="products-grid">
            <?php foreach ($related_products as $related): ?>
                <div class="product-card">
                    <div class="product-image">
                        <?php if ($related['primary_image']): ?>
                            <img src="<?php echo SITE_URL; ?>uploads/<?php echo $related['primary_image']; ?>" 
                                 alt="<?php echo htmlspecialchars($related['name']); ?>">
                        <?php else: ?>
                            <img src="<?php echo SITE_URL; ?>assets/images/placeholder-product.jpg" 
                                 alt="<?php echo htmlspecialchars($related['name']); ?>">
                        <?php endif; ?>
                        <?php if ($related['discount_price']): ?>
                            <span class="discount-badge">-<?php echo round((($related['price'] - $related['discount_price']) / $related['price']) * 100); ?>%</span>
                        <?php endif; ?>
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">
                            <a href="product.php?slug=<?php echo $related['slug']; ?>">
                                <?php echo htmlspecialchars($related['name']); ?>
                            </a>
                        </h3>
                        <p class="product-description">
                            <?php echo truncateText($related['short_description'] ?? '', 80); ?>
                        </p>
                        <div class="product-price">
                            <?php if ($related['discount_price']): ?>
                                <span class="current-price"><?php echo formatPrice($related['discount_price']); ?></span>
                                <span class="original-price"><?php echo formatPrice($related['price']); ?></span>
                            <?php else: ?>
                                <span class="current-price"><?php echo formatPrice($related['price']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="product-actions">
                            <a href="product.php?slug=<?php echo $related['slug']; ?>" class="btn btn-outline">View Details</a>
                            <button class="btn btn-primary add-to-cart" data-product-id="<?php echo $related['id']; ?>">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
