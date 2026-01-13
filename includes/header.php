<?php
/**
 * Professional Header Component
 * Divyaghar E-commerce Website
 */

// Get cart count
$cart_count = getCartCount();

// Get categories for navigation
$categories = $db->fetchAll("SELECT id, name, slug FROM categories WHERE status = 'active' ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Divyaghar'; ?></title>
    
    <?php if (isset($meta_description)): ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php else: ?>
    <meta name="description" content="Divyaghar - High-quality pooja essentials, home décor, god idols, and spiritual gifts.">
    <?php endif; ?>
    
    <?php if (isset($meta_keywords)): ?>
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <?php else: ?>
    <meta name="keywords" content="pooja essentials, home decor, god idols, spiritual gifts, divyaghar">
    <?php endif; ?>
    
    <meta name="author" content="Divyaghar">
    <meta property="og:title" content="<?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Divyaghar'; ?>">
    <meta property="og:description" content="High-quality pooja essentials, home décor, god idols, and spiritual gifts">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS - Complete Theme -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/premium_theme.css?v=<?php echo time(); ?>">
    
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>assets/images/favicon.ico">
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
                        <a href="careers.php">Our Story</a>
                        <a href="shipping.php">Shipping Info</a>
                        <a href="returns.php">Returns & Exchanges</a>
                        <a href="size-guide.php">Size Guide</a>
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
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-count"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
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

<!-- Mobile Navigation -->
<div class="mobile-nav" style="display: none;">
    <div class="mobile-nav-header">
        <div class="mobile-nav-logo" style="display: none;">
            <span class="logo-text">Divyaghar</span>
        </div>
        <button class="mobile-menu-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <nav class="mobile-nav-menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">All Products</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="cart.php">Cart (<?php echo $cart_count; ?>)</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</div>
