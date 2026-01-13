<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 Header Fix Test - Divyaghar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/spiritual_theme.css?v=<?php echo time(); ?>">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }
        .test-content {
            padding: 4rem 2rem;
            text-align: center;
        }
        .status {
            background: #d4ed31;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 600px;
        }
        .btn {
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin: 10px 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-main">
            <div class="logo">
                <a href="index.php">
                    <img src="https://via.placeholder.com/45x45/D4AF37/ffffff?text=DG" alt="Divyaghar Logo" width="45" height="45">
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
                    <input type="text" placeholder="Search products...">
                    <button type="button"><i class="fas fa-search"></i></button>
                </div>
                
                <div class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">0</span>
                </div>
                
                <div class="user-menu">
                    <a href="login.php"><i class="fas fa-user"></i> Login</a>
                    <a href="register.php"><i class="fas fa-user-plus"></i> Register</a>
                </div>
            </div>
            
            <button class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Test Content -->
    <div class="test-content">
        <h1>🔧 Header Fix Test</h1>
        
        <div class="status">
            <h2>✅ Header Structure Fixed!</h2>
            <p>The header should now display properly with:</p>
            <ul style="text-align: left; max-width: 400px; margin: 0 auto;">
                <li>✅ Spiritual gold gradient background</li>
                <li>✅ Proper logo alignment</li>
                <li>✅ Working navigation menu</li>
                <li>✅ Dropdown menu functionality</li>
                <li>✅ Search box styling</li>
                <li>✅ Cart icon with count</li>
                <li>✅ User login/register buttons</li>
                <li>✅ Mobile responsive design</li>
            </ul>
        </div>
        
        <p><strong>Test the header features:</strong></p>
        <ul style="text-align: left; max-width: 400px; margin: 0 auto;">
            <li>🖱️ Hover over navigation links</li>
            <li>📋 Click on "Pages" dropdown</li>
            <li>🔍 Type in the search box</li>
            <li>🛒 Check cart icon hover</li>
            <li>📱 Resize browser to test mobile</li>
        </ul>
        
        <div style="margin-top: 30px;">
            <button class="btn" onclick="window.location.href='index.php'">🏠 Test Main Website</button>
            <button class="btn" onclick="window.location.href='spiritual_theme_test.php'">🌟 Test Spiritual Theme</button>
        </div>
    </div>
</body>
</html>
