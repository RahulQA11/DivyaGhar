<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌟 Premium Theme Test - Divyaghar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/premium_theme.css?v=<?php echo time(); ?>">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .test-section {
            padding: 4rem 2rem;
            text-align: center;
        }
        .color-palette {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .color-box {
            height: 120px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .status {
            background: #FFD700;
            color: #1a1a1a;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 600px;
        }
        .btn {
            background: linear-gradient(135deg, #FFD700 0%, #FF8C00 100%);
            color: #1a1a1a;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin: 10px 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255, 215, 0, 0.4);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-main">
            <div class="logo">
                <a href="index.php">
                    <img src="https://via.placeholder.com/45x45/FFD700/1a1a1a?text=DG" alt="Divyaghar Logo" width="45" height="45">
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">🌟 Premium Theme Applied</h1>
                <p class="hero-subtitle">Experience luxury design with premium colors</p>
                <div class="hero-buttons">
                    <a href="index.php" class="btn btn-primary btn-large">🏠 View Website</a>
                    <a href="#" class="btn btn-outline btn-large">🎨 Test Colors</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://via.placeholder.com/500x400/1a1a1a/FFD700?text=Premium+Design" alt="Premium Theme">
            </div>
        </div>
    </section>

    <!-- Color Palette Test -->
    <section class="test-section" style="background: #FAFAFA;">
        <h2 class="section-title">🎨 Premium Color Palette</h2>
        <p class="section-subtitle">Experience the luxury colors of our premium theme</p>
        
        <div class="color-palette">
            <div class="color-box" style="background: #1a1a1a;">
                Deep Black<br>#1a1a1a
            </div>
            <div class="color-box" style="background: #FFD700;">
                Premium Gold<br>#FFD700
            </div>
            <div class="color-box" style="background: #8B4513;">
                Rich Brown<br>#8B4513
            </div>
            <div class="color-box" style="background: #FF8C00;">
                Dark Saffron<br>#FF8C00
            </div>
            <div class="color-box" style="background: #E91E63;">
                Deep Rose<br>#E91E63
            </div>
            <div class="color-box" style="background: #6A1B9A;">
                Deep Purple<br>#6A1B9A
            </div>
        </div>
    </section>

    <!-- Features Test -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">✨ Premium Features</h2>
            <p class="section-subtitle">Experience the luxury design elements</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🌟</div>
                    <h3 class="feature-title">Premium Colors</h3>
                    <p class="feature-description">Deep black with gold accents for luxury appearance</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎨</div>
                    <h3 class="feature-title">Modern Design</h3>
                    <p class="feature-description">Clean, modern design with luxury elements and smooth animations</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3 class="feature-title">Premium Theme</h3>
                    <p class="feature-description">Complete premium theme with luxury color palette and elegant styling</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Status Section -->
    <section class="test-section">
        <div class="status">
            <h2>✅ All Issues Fixed!</h2>
            <p><strong>1. Single Logo:</strong> Duplicate mobile logo removed</p>
            <p><strong>2. Navigation Fixed:</strong> About Us properly aligned</p>
            <p><strong>3. Premium Colors:</strong> Luxury black & gold theme applied</p>
        </div>
        
        <div style="margin-top: 30px;">
            <button class="btn" onclick="window.location.href='index.php'">🏠 Test Main Website</button>
            <button class="btn" onclick="window.location.href='header_fix_test.php'">🔧 Compare with Old</button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-column">
                    <h4>🌟 Divyaghar</h4>
                    <p>Experience the premium luxury theme with deep black and gold colors.</p>
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
                    <h4>Theme Features</h4>
                    <ul>
                        <li><a href="#">Premium Colors</a></li>
                        <li><a href="#">Luxury Design</a></li>
                        <li><a href="#">Modern Layout</a></li>
                        <li><a href="#">Smooth Animations</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Divyaghar. All rights reserved. Premium Luxury Theme Applied.</p>
            </div>
        </div>
    </footer>
</body>
</html>
