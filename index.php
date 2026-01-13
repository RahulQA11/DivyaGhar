<?php
/**
 * Home Page - Complete E-commerce Design
 * Divyaghar - Spiritual & Home Décor Store
 */

require_once 'config/database.php';

// Set page meta
$page_title = 'Divyaghar - Premium Spiritual & Home Décor Store';
$meta_description = 'Divyaghar - High-quality pooja essentials, home décor, god idols, and spiritual gifts. Bring divinity home with our premium collection.';
$meta_keywords = 'pooja essentials, home decor, god idols, spiritual gifts, divyaghar, brass items, sandalwood, incense';

// Get featured products
try {
    $featured_products = $db->fetchAll("SELECT p.*, c.name as category_name, c.slug as category_slug,
                                       (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 'yes' LIMIT 1) as primary_image
                                       FROM products p 
                                       LEFT JOIN categories c ON p.category_id = c.id 
                                       WHERE p.featured = 'yes' AND p.status = 'active' 
                                       ORDER BY RAND() LIMIT 8");
} catch (Exception $e) {
    $featured_products = [];
    error_log("Featured products error: " . $e->getMessage());
}

// Get categories
try {
    $categories = $db->fetchAll("SELECT * FROM categories WHERE status = 'active' ORDER BY name ASC LIMIT 6");
} catch (Exception $e) {
    $categories = [];
    error_log("Categories error: " . $e->getMessage());
}

// Get latest products
try {
    $latest_products = $db->fetchAll("SELECT p.*, c.name as category_name, c.slug as category_slug,
                                     (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 'yes' LIMIT 1) as primary_image
                                     FROM products p 
                                     LEFT JOIN categories c ON p.category_id = c.id 
                                     WHERE p.status = 'active' 
                                     ORDER BY p.created_at DESC LIMIT 6");
} catch (Exception $e) {
    $latest_products = [];
    error_log("Latest products error: " . $e->getMessage());
}

// Get cart count
$cart_count = getCartCount();

include 'includes/header.php';
?>

<!-- Categories Bar -->
<section class="categories-bar">
    <div class="categories-bar-content">
        <h2 class="categories-title">Shop by Category</h2>
        <nav class="categories-nav">
            <a href="products.php?category=pooja"><i class="fas fa-fire"></i> Pooja Essentials</a>
            <a href="products.php?category=idols"><i class="fas fa-om"></i> God Idols</a>
            <a href="products.php?category=decor"><i class="fas fa-home"></i> Home Decor</a>
            <a href="products.php?category=gifts"><i class="fas fa-gift"></i> Spiritual Gifts</a>
            <a href="products.php?category=books"><i class="fas fa-book"></i> Religious Books</a>
            <a href="products.php?category=yantras"><i class="fas fa-gem"></i> Yantras</a>
        </nav>
    </div>
</section>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">Discover Divine Spiritual Essentials</h1>
            <p class="hero-subtitle">Experience the perfect blend of tradition and elegance with our curated collection of pooja essentials, home décor, and spiritual gifts.</p>
            <div class="hero-buttons">
                <a href="products.php" class="btn btn-primary btn-large">🛍️ Shop Now</a>
                <a href="#featured" class="btn btn-outline btn-large">🙏 Explore Products</a>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-image-wrapper">
                <img src="<?php echo SITE_URL; ?>assets/images/hero-image.svg" alt="Spiritual Essentials">
                <div class="hero-badge">Premium Quality</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products-section" id="featured">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured Products</h2>
            <p class="section-subtitle">Handpicked favorites from our premium collection</p>
        </div>
        
        <?php if (empty($featured_products)): ?>
            <div class="products-grid">
                <!-- Sample products for demo -->
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="<?php echo SITE_URL; ?>assets/images/products/diya.jpg" alt="Premium Diyas" class="product-image">
                        <div class="product-overlay">
                            <button class="quick-view-btn">👁️ Quick View</button>
                        </div>
                        <div class="product-badges">
                            <span class="product-badge badge-featured">Featured</span>
                            <span class="product-badge badge-new">New</span>
                        </div>
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">
                            <a href="#">Premium Brass Diyas Set</a>
                        </h3>
                        <div class="product-rating">
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                            <span class="rating-count">(245)</span>
                        </div>
                        <div class="product-price">
                            <span class="price-current">₹1,299</span>
                            <span class="price-original">₹1,599</span>
                        </div>
                        <p class="product-description">Elegant brass diyas perfect for daily pooja and special occasions.</p>
                        <div class="product-actions">
                            <button class="btn btn-primary">🛒 Add to Cart</button>
                            <button class="btn btn-outline">❤️ Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($featured_products as $index => $product): ?>
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <img src="<?php echo getProductImage($product['primary_image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                            <div class="product-overlay">
                                <button class="quick-view-btn">👁️ Quick View</button>
                            </div>
                            <div class="product-badges">
                                <?php if ($product['featured'] === 'yes'): ?>
                                    <span class="product-badge badge-featured">Featured</span>
                                <?php endif; ?>
                                <span class="product-badge badge-new">New</span>
                                <?php if ($product['discount_price']): ?>
                                    <span class="product-badge badge-sale">Sale</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">
                                <a href="product.php?slug=<?php echo $product['slug']; ?>">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </a>
                            </h3>
                            <div class="product-rating">
                                <div class="stars">⭐⭐⭐⭐⭐</div>
                                <span class="rating-count">(<?php echo rand(100, 500); ?>)</span>
                            </div>
                            <div class="product-price">
                                <?php if ($product['discount_price']): ?>
                                    <span class="price-current"><?php echo formatPrice($product['discount_price']); ?></span>
                                    <span class="price-original"><?php echo formatPrice($product['price']); ?></span>
                                <?php else: ?>
                                    <span class="price-current"><?php echo formatPrice($product['price']); ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="product-description">
                                <?php echo truncateText($product['short_description'] ?? $product['description'], 100); ?>
                            </p>
                            <div class="product-actions">
                                <button class="btn btn-primary add-to-cart" data-product-id="<?php echo $product['id']; ?>">🛒 Add to Cart</button>
                                <button class="btn btn-outline">❤️ Wishlist</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 3rem;">
            <a href="products.php" class="btn btn-primary btn-large">🛍️ View All Products</a>
        </div>
    </div>
</section>

<!-- Special Offers Section -->
<section class="special-offers-section">
    <div class="offers-content">
        <h2 class="offers-title">🎉 Special Offers & Discounts</h2>
        <p class="offers-subtitle">Exclusive deals on our premium spiritual products</p>
        
        <div class="offers-grid">
            <div class="offer-card">
                <div class="offer-icon">🔥</div>
                <h3 class="offer-title">Flash Sale</h3>
                <p class="offer-description">Get up to 50% off on selected pooja essentials</p>
                <div class="offer-code">FLASH50</div>
            </div>
            
            <div class="offer-card">
                <div class="offer-icon">🎁</div>
                <h3 class="offer-title">First Order Discount</h3>
                <p class="offer-description">Save 20% on your first purchase</p>
                <div class="offer-code">FIRST20</div>
            </div>
            
            <div class="offer-card">
                <div class="offer-icon">🚚</div>
                <h3 class="offer-title">Free Shipping</h3>
                <p class="offer-description">Free delivery on orders above ₹999</p>
                <div class="offer-code">FREESHIP</div>
            </div>
            
            <div class="offer-card">
                <div class="offer-icon">💎</div>
                <h3 class="offer-title">Premium Collection</h3>
                <p class="offer-description">30% off on premium brass idols</p>
                <div class="offer-code">PREMIUM30</div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-subtitle">Real experiences from our valued customers</p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    "Absolutely love the quality of products from Divyaghar! The brass diya set I purchased exceeded my expectations. The craftsmanship is exceptional and the packaging was perfect."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">RK</div>
                    <div class="author-info">
                        <div class="author-name">Rahul Kumar</div>
                        <div class="author-role">Verified Buyer</div>
                    </div>
                </div>
                <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    "I've been searching for authentic spiritual products and finally found Divyaghar. The Shiva idol is beautifully crafted and the customer service was outstanding. Highly recommend!"
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">PS</div>
                    <div class="author-info">
                        <div class="author-name">Priya Sharma</div>
                        <div class="author-role">Regular Customer</div>
                    </div>
                </div>
                <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    "The rudraksha mala I purchased is genuine and of excellent quality. Fast delivery and great customer support. Divyaghar is now my go-to store for all spiritual needs."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">AM</div>
                    <div class="author-info">
                        <div class="author-name">Amit Mehta</div>
                        <div class="author-role">Spiritual Practitioner</div>
                    </div>
                </div>
                <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="newsletter-content">
        <h2 class="newsletter-title">Stay Connected with Divinity</h2>
        <p class="newsletter-description">Subscribe to receive exclusive offers, spiritual insights, and new product updates</p>
        <form class="newsletter-form">
            <input type="email" class="newsletter-input" placeholder="Enter your email address" required>
            <button type="submit" class="newsletter-button">Subscribe Now</button>
        </form>
    </div>
</section>

<!-- Trust Badges Section -->
<section class="trust-badges-section">
    <div class="container">
        <div class="trust-badges-grid">
            <div class="trust-badge-item">
                <div class="trust-badge-icon">🔒</div>
                <h4 class="trust-badge-title">Secure Payment</h4>
                <p class="trust-badge-description">100% secure transactions with SSL encryption</p>
            </div>
            
            <div class="trust-badge-item">
                <div class="trust-badge-icon">🚚</div>
                <h4 class="trust-badge-title">Fast Delivery</h4>
                <p class="trust-badge-description">Quick delivery across India</p>
            </div>
            
            <div class="trust-badge-item">
                <div class="trust-badge-icon">🔄</div>
                <h4 class="trust-badge-title">Easy Returns</h4>
                <p class="trust-badge-description">7-day hassle-free returns</p>
            </div>
            
            <div class="trust-badge-item">
                <div class="trust-badge-icon">💎</div>
                <h4 class="trust-badge-title">Authentic Products</h4>
                <p class="trust-badge-description">100% genuine spiritual items</p>
            </div>
            
            <div class="trust-badge-item">
                <div class="trust-badge-icon">📞</div>
                <h4 class="trust-badge-title">24/7 Support</h4>
                <p class="trust-badge-description">Dedicated customer service</p>
            </div>
            
            <div class="trust-badge-item">
                <div class="trust-badge-icon">⭐</div>
                <h4 class="trust-badge-title">Premium Quality</h4>
                <p class="trust-badge-description">High-quality craftsmanship</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
