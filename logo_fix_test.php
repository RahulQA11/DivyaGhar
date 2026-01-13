<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 Logo Fix Test - Divyaghar</title>
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
        .comparison {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .comparison-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
        }
        .comparison-box h4 {
            color: #1a1a1a;
            margin-bottom: 15px;
        }
        .before {
            border-color: #dc3545;
        }
        .after {
            border-color: #28a745;
        }
    </style>
</head>
<body>
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

    <!-- Test Content -->
    <section class="test-section">
        <h1>🔧 Logo Fix Test</h1>
        
        <div class="status">
            <h2>✅ Logo Issues Fixed!</h2>
            <p><strong>1. Text-Only Logo:</strong> Image removed, text-only logo</p>
            <p><strong>2. No Overlapping:</strong> Proper spacing from navigation</p>
            <p><strong>3. Better Styling:</strong> Clean text logo with proper font</p>
        </div>
        
        <div class="comparison">
            <div class="comparison-box before">
                <h4>❌ Before (Issues)</h4>
                <ul style="text-align: left;">
                    <li>Logo image + text overlapping</li>
                    <li>Home button overlapped</li>
                    <li>Poor spacing</li>
                    <li>Image loading issues</li>
                </ul>
            </div>
            <div class="comparison-box after">
                <h4>✅ After (Fixed)</h4>
                <ul style="text-align: left;">
                    <li>Clean text-only logo</li>
                    <li>Proper spacing</li>
                    <li>No overlapping</li>
                    <li>Elegant typography</li>
                </ul>
            </div>
        </div>
        
        <div style="margin-top: 30px;">
            <h3>🎨 Logo Features:</h3>
            <ul style="text-align: left; max-width: 400px; margin: 0 auto;">
                <li>🌟 Text-only logo "Divyaghar"</li>
                <li>🎨 Playfair Display font</li>
                <li>✨ White color with gold hover</li>
                <li>📏 Proper spacing and sizing</li>
                <li>🔧 No overlapping with navigation</li>
                <li>📱 Responsive design</li>
            </ul>
        </div>
        
        <div style="margin-top: 30px;">
            <button class="btn" onclick="window.location.href='index.php'">🏠 Test Main Website</button>
            <button class="btn" onclick="window.location.href='premium_theme_test.php'">🌟 Test Premium Theme</button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-column">
                    <h4>🌟 Divyaghar</h4>
                    <p>Experience the premium luxury theme with text-only logo.</p>
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
                        <li><a href="#">Text-Only Logo</a></li>
                        <li><a href="#">Premium Colors</a></li>
                        <li><a href="#">Modern Layout</a></li>
                        <li><a href="#">Smooth Animations</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Divyaghar. All rights reserved. Logo Issues Fixed.</p>
            </div>
        </div>
    </footer>
</body>
</html>
