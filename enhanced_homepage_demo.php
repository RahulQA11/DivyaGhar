<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌟 Enhanced Homepage - Divyaghar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/premium_theme.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/enhanced_homepage.css?v=<?php echo time(); ?>">
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
    </style>
</head>
<body>
    <!-- Demo Notice -->
    <div class="demo-notice">
        🌟 Enhanced Homepage Design Demo - Experience the User-Friendly & Engaging Design
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
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Pages</a>
                        <div class="dropdown-menu">
                            <a href="about.php">About Us</a>
                            <a href="blog.php">Blog</a>
                            <a href="faq.php">FAQ</a>
                            <a href="testimonials.php">Testimonials</a>
                            <a href="track-order.php">Track Order</a>
                            <a href="gallery.php">Gallery</a>
                            <a href="offers.php">Special Offers</a>
                            <a href="reviews.php">Customer Reviews</a>
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
                        <span class="cart-count">0</span>
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

    <!-- Enhanced Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Discover Divine Spiritual Essentials</h1>
                <p class="hero-subtitle">Experience the perfect blend of tradition and elegance with our curated collection of pooja essentials, home décor, and spiritual gifts.</p>
                <div class="hero-buttons">
                    <a href="products.php" class="btn btn-primary btn-large">🛍️ Shop Now</a>
                    <a href="about.php" class="btn btn-outline btn-large">🙏 Learn More</a>
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

    <!-- Enhanced Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="features-header">
                <h2 class="features-title">Why Choose Divyaghar</h2>
                <p class="features-subtitle">We bring you the finest spiritual products with unmatched quality and service</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">🌟</div>
                    </div>
                    <h3 class="feature-title">Premium Quality</h3>
                    <p class="feature-description">Handpicked products crafted with care and attention to detail, ensuring the highest quality for your spiritual needs.</p>
                    <a href="#" class="feature-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">🚚</div>
                    </div>
                    <h3 class="feature-title">Fast Delivery</h3>
                    <p class="feature-description">Quick and reliable delivery across the country, bringing spiritual peace right to your doorstep.</p>
                    <a href="#" class="feature-link">Shipping Info <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">💎</div>
                    </div>
                    <h3 class="feature-title">Authentic Products</h3>
                    <p class="feature-description">Genuine spiritual items sourced directly from trusted artisans and manufacturers.</p>
                    <a href="#" class="feature-link">Our Promise <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">🤝</div>
                    </div>
                    <h3 class="feature-title">Customer Support</h3>
                    <p class="feature-description">Dedicated support team ready to assist you with any questions or concerns.</p>
                    <a href="#" class="feature-link">Contact Us <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">🎁</div>
                    </div>
                    <h3 class="feature-title">Special Offers</h3>
                    <p class="feature-description">Exclusive deals and discounts on our premium spiritual products and collections.</p>
                    <a href="#" class="feature-link">View Offers <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">🔒</div>
                    </div>
                    <h3 class="feature-title">Secure Shopping</h3>
                    <p class="feature-description">Safe and secure payment options with encrypted transactions for your peace of mind.</p>
                    <a href="#" class="feature-link">Security <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="categories-header">
                <h2 class="categories-title">Explore Our Categories</h2>
                <p class="categories-subtitle">Discover our wide range of spiritual products organized for your convenience</p>
            </div>
            
            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-image-wrapper">
                        <img src="https://via.placeholder.com/400x250/8B4513/FFFFFF?text=Pooja+Essentials" alt="Pooja Essentials" class="category-image">
                        <div class="category-overlay"></div>
                        <div class="category-badge">Popular</div>
                    </div>
                    <div class="category-content">
                        <h3 class="category-name">Pooja Essentials</h3>
                        <p class="category-description">Complete range of pooja items including diyas, incense, and sacred texts.</p>
                        <a href="#" class="category-link">Explore Category <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="category-card">
                    <div class="category-image-wrapper">
                        <img src="https://via.placeholder.com/400x250/FFD700/1a1a1a?text=God+Idols" alt="God Idols" class="category-image">
                        <div class="category-overlay"></div>
                        <div class="category-badge">Featured</div>
                    </div>
                    <div class="category-content">
                        <h3 class="category-name">God Idols</h3>
                        <p class="category-description">Beautifully crafted idols of various deities for your home and temples.</p>
                        <a href="#" class="category-link">Explore Category <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="category-card">
                    <div class="category-image-wrapper">
                        <img src="https://via.placeholder.com/400x250/6A1B9A/FFFFFF?text=Home+Decor" alt="Home Decor" class="category-image">
                        <div class="category-overlay"></div>
                    </div>
                    <div class="category-content">
                        <h3 class="category-name">Home Decor</h3>
                        <p class="category-description">Elegant spiritual home decor items to create a peaceful atmosphere.</p>
                        <a href="#" class="category-link">Explore Category <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="category-card">
                    <div class="category-image-wrapper">
                        <img src="https://via.placeholder.com/400x250/E91E63/FFFFFF?text=Spiritual+Gifts" alt="Spiritual Gifts" class="category-image">
                        <div class="category-overlay"></div>
                    </div>
                    <div class="category-content">
                        <h3 class="category-name">Spiritual Gifts</h3>
                        <p class="category-description">Thoughtful gifts for spiritual occasions and celebrations.</p>
                        <a href="#" class="category-link">Explore Category <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Products Section -->
    <section class="products-section">
        <div class="container">
            <div class="products-header">
                <h2 class="products-title">Featured Products</h2>
                <p class="products-subtitle">Handpicked favorites from our premium collection</p>
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
            </div>
        </div>
    </section>

    <!-- Enhanced Newsletter Section -->
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

    <!-- Enhanced Trust Section -->
    <section class="trust-section">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-item">
                    <div class="trust-icon">🚚</div>
                    <h3 class="trust-title">Free Shipping</h3>
                    <p class="trust-description">On orders above ₹999</p>
                </div>
                
                <div class="trust-item">
                    <div class="trust-icon">🔄</div>
                    <h3 class="trust-title">Easy Returns</h3>
                    <p class="trust-description">7-day return policy</p>
                </div>
                
                <div class="trust-item">
                    <div class="trust-icon">💳</div>
                    <h3 class="trust-title">Secure Payment</h3>
                    <p class="trust-description">100% secure transactions</p>
                </div>
                
                <div class="trust-item">
                    <div class="trust-icon">📞</div>
                    <h3 class="trust-title">24/7 Support</h3>
                    <p class="trust-description">Dedicated customer service</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-column">
                    <h4>🌟 Divyaghar</h4>
                    <p>Your trusted destination for premium spiritual products and divine essentials.</p>
                </div>
                <div class="footer-column">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="#">Pooja Essentials</a></li>
                        <li><a href="#">God Idols</a></li>
                        <li><a href="#">Home Decor</a></li>
                        <li><a href="#">Spiritual Gifts</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Divyaghar. All rights reserved. Enhanced Homepage Design.</p>
            </div>
        </div>
    </footer>
</body>
</html>
