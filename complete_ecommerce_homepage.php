<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌟 Complete E-commerce Homepage - Divyaghar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/premium_theme.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/complete_ecommerce_fix.css?v=<?php echo time(); ?>">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .demo-notice {
            background: linear-gradient(135deg, #FFD700 0%, #FF8C00 100%);
            color: #1a1a1a;
            padding: 15px;
            text-align: center;
            font-weight: 600;
        }
        .analysis-section {
            background: #f8f9fa;
            padding: 2rem;
            border-left: 4px solid #FFD700;
            margin: 2rem 0;
        }
        .analysis-section h3 {
            color: #1a1a1a;
            margin-bottom: 1rem;
        }
        .analysis-section ul {
            color: #333;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <!-- Demo Notice -->
    <div class="demo-notice">
        🌟 Complete E-commerce Homepage - All Issues Fixed & Missing Elements Added
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-main">
            <div class="logo">
                <a href="index.php">
                    <span class="logo-text">Divyaghar</span>
                </a>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Pages</a>
                        <div class="dropdown-menu">
                            <a href="blog.php">Blog</a>
                            <a href="faq.php">FAQ</a>
                            <a href="testimonials.php">Testimonials</a>
                            <a href="track-order.php">Track Order</a>
                            <a href="offers.php">Special Offers</a>
                        </div>
                    </li>
                </ul>
            </nav>
            
            <div class="header-actions">
                <div class="search-box">
                    <form action="search.php" method="GET">
                        <input type="text" name="q" placeholder="Search products...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                
                <div class="cart-icon">
                    <a href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Cart</span>
                        <span class="cart-count">3</span>
                    </a>
                </div>
                
                <div class="user-menu">
                    <a href="login.php"><i class="fas fa-user"></i></a>
                </div>
                
                <button class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Categories Bar - MISSING ELEMENT -->
    <section class="categories-bar">
        <div class="categories-bar-content">
            <h2 class="categories-title">Shop by Category</h2>
            <nav class="categories-nav">
                <a href="#"><i class="fas fa-fire"></i> Pooja Essentials</a>
                <a href="#"><i class="fas fa-om"></i> God Idols</a>
                <a href="#"><i class="fas fa-home"></i> Home Decor</a>
                <a href="#"><i class="fas fa-gift"></i> Spiritual Gifts</a>
                <a href="#"><i class="fas fa-book"></i> Religious Books</a>
                <a href="#"><i class="fas fa-gem"></i> Yantras</a>
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
                    <img src="https://via.placeholder.com/500x400/1a1a1a/FFD700?text=Spiritual+Essentials" alt="Spiritual Essentials">
                    <div class="hero-badge">Premium Quality</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Analysis Section -->
    <div class="container">
        <div class="analysis-section">
            <h3>🔍 Issues Identified from Screenshot:</h3>
            <ul>
                <li><strong>❌ Missing Categories Bar:</strong> No category navigation below header</li>
                <li><strong>❌ Incomplete Hero Section:</strong> Basic hero without proper e-commerce elements</li>
                <li><strong>❌ Missing Featured Products:</strong> No product showcase section</li>
                <li><strong>❌ No Special Offers:</strong> Missing promotional banners/discounts</li>
                <li><strong>❌ Missing Testimonials:</strong> No customer reviews section</li>
                <li><strong>❌ No Trust Badges:</strong> Missing payment/security badges</li>
                <li><strong>❌ Incomplete Footer:</strong> Basic footer without e-commerce elements</li>
                <li><strong>❌ Missing Newsletter:</strong> No email capture section</li>
                <li><strong>❌ No Brand Story:</strong> Missing about section integration</li>
                <li><strong>❌ Missing CTA Elements:</strong> Limited call-to-action buttons</li>
            </ul>
        </div>
    </div>

    <!-- Featured Products Section - MISSING -->
    <section class="featured-products-section" id="featured">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Featured Products</h2>
                <p class="section-subtitle">Handpicked favorites from our premium collection</p>
            </div>
            
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="https://via.placeholder.com/320x280/1a1a1a/FFD700?text=Premium+Diyas" alt="Premium Diyas" class="product-image">
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
                
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="https://via.placeholder.com/320x280/8B4513/FFFFFF?text=Shiva+Idol" alt="Shiva Idol" class="product-image">
                        <div class="product-overlay">
                            <button class="quick-view-btn">👁️ Quick View</button>
                        </div>
                        <div class="product-badges">
                            <span class="product-badge badge-sale">Sale</span>
                        </div>
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">
                            <a href="#">Divine Shiva Idol</a>
                        </h3>
                        <div class="product-rating">
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                            <span class="rating-count">(189)</span>
                        </div>
                        <div class="product-price">
                            <span class="price-current">₹2,499</span>
                            <span class="price-original">₹3,199</span>
                        </div>
                        <p class="product-description">Beautifully crafted Shiva idol in premium brass with intricate details.</p>
                        <div class="product-actions">
                            <button class="btn btn-primary">🛒 Add to Cart</button>
                            <button class="btn btn-outline">❤️ Wishlist</button>
                        </div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="https://via.placeholder.com/320x280/FFD700/1a1a1a?text=Rudraksha+Mala" alt="Rudraksha Mala" class="product-image">
                        <div class="product-overlay">
                            <button class="quick-view-btn">👁️ Quick View</button>
                        </div>
                        <div class="product-badges">
                            <span class="product-badge badge-featured">Featured</span>
                        </div>
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">
                            <a href="#">Original Rudraksha Mala</a>
                        </h3>
                        <div class="product-rating">
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                            <span class="rating-count">(412)</span>
                        </div>
                        <div class="product-price">
                            <span class="price-current">₹899</span>
                            <span class="price-original">₹1,299</span>
                        </div>
                        <p class="product-description">Genuine rudraksha mala for meditation and spiritual practices.</p>
                        <div class="product-actions">
                            <button class="btn btn-primary">🛒 Add to Cart</button>
                            <button class="btn btn-outline">❤️ Wishlist</button>
                        </div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="https://via.placeholder.com/320x280/6A1B9A/FFFFFF?text=Ganesh+Idol" alt="Ganesh Idol" class="product-image">
                        <div class="product-overlay">
                            <button class="quick-view-btn">👁️ Quick View</button>
                        </div>
                        <div class="product-badges">
                            <span class="product-badge badge-new">New</span>
                        </div>
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">
                            <a href="#">Ganesh Marble Idol</a>
                        </h3>
                        <div class="product-rating">
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                            <span class="rating-count">(156)</span>
                        </div>
                        <div class="product-price">
                            <span class="price-current">₹3,999</span>
                            <span class="price-original">₹4,999</span>
                        </div>
                        <p class="product-description">Exquisite marble Ganesh idol with detailed craftsmanship.</p>
                        <div class="product-actions">
                            <button class="btn btn-primary">🛒 Add to Cart</button>
                            <button class="btn btn-outline">❤️ Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="products.php" class="btn btn-primary btn-large">🛍️ View All Products</a>
            </div>
        </div>
    </section>

    <!-- Special Offers Section - MISSING -->
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

    <!-- Testimonials Section - MISSING -->
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

    <!-- Trust Badges Section - MISSING -->
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

    <!-- Enhanced Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-column">
                    <h4>🌟 About Divyaghar</h4>
                    <p>Your trusted destination for premium spiritual products and divine essentials. We bring you authentic items for your spiritual journey.</p>
                    <div style="margin-top: 1rem;">
                        <a href="#" class="btn btn-outline btn-small">Learn More</a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">All Products</a></li>
                        <li><a href="categories.php">Categories</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="blog.php">Blog</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="shipping.php">Shipping Info</a></li>
                        <li><a href="returns.php">Returns</a></li>
                        <li><a href="track-order.php">Track Order</a></li>
                        <li><a href="size-guide.php">Size Guide</a></li>
                        <li><a href="careers.php">Careers</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>Contact Info</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> +91 98765 43210</li>
                        <li><i class="fas fa-envelope"></i> info@divyaghar.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Mumbai, Maharashtra, India</li>
                        <li><i class="fas fa-clock"></i> Mon-Sat: 9AM-6PM</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
                <p>&copy; 2024 Divyaghar. All rights reserved. | <a href="privacy.php">Privacy Policy</a> | <a href="terms.php">Terms & Conditions</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
