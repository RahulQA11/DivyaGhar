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
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/premium_theme.css?v=<?php echo time(); ?>123456789">
    
    <!-- Enhanced Header JavaScript -->
    <script src="<?php echo SITE_URL; ?>assets/js/enhanced-header.js?v=<?php echo time(); ?>" defer></script>
    
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>assets/images/favicon.ico">
</head>
<body>

<!-- Header -->
<header class="header" id="mainHeader">
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
            <div class="search-box enhanced-search">
                <form action="search.php" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <input type="text" name="q" placeholder="Search products..." class="search-input">
                        <div class="search-suggestions" id="searchSuggestions" style="display: none;">
                            <div class="suggestions-header">Popular Searches</div>
                            <div class="suggestions-list">
                                <a href="search.php?q=ganesh+idol" class="suggestion-item">
                                    <i class="fas fa-search"></i> Ganesh Idol
                                </a>
                                <a href="search.php?q=shiv+ling" class="suggestion-item">
                                    <i class="fas fa-search"></i> Shiv Ling
                                </a>
                                <a href="search.php?q=diya" class="suggestion-item">
                                    <i class="fas fa-search"></i> Diya
                                </a>
                                <a href="search.php?q=rudraksha" class="suggestion-item">
                                    <i class="fas fa-search"></i> Rudraksha
                                </a>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                    <button type="button" class="voice-search-btn" id="voiceSearchBtn">
                        <i class="fas fa-microphone"></i>
                    </button>
                </form>
            </div>
            
            <div class="cart-icon">
                <a href="cart.php" class="cart-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-label">Cart</span>
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-count"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a>
            </div>
            
            <div class="user-menu enhanced-user-menu">
                <div class="user-dropdown">
                    <button class="user-dropdown-toggle" id="userDropdownToggle">
                        <i class="fas fa-user"></i>
                        <span class="user-label">Account</span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </button>
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <?php if (isLoggedIn()): ?>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="user-details">
                                    <div class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
                                    <div class="user-email"><?php echo htmlspecialchars($_SESSION['user_email']); ?></div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="account.php" class="dropdown-item">
                                <i class="fas fa-user-circle"></i> My Account
                            </a>
                            <a href="orders.php" class="dropdown-item">
                                <i class="fas fa-box"></i> My Orders
                            </a>
                            <a href="wishlist.php" class="dropdown-item">
                                <i class="fas fa-heart"></i> Wishlist
                                <?php 
                                $wishlist_count = getWishlistCount();
                                if ($wishlist_count > 0): 
                                ?>
                                    <span class="wishlist-count"><?php echo $wishlist_count; ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="addresses.php" class="dropdown-item">
                                <i class="fas fa-map-marker-alt"></i> Addresses
                            </a>
                            <a href="settings.php" class="dropdown-item">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item logout-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="dropdown-item">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                            <a href="register.php" class="dropdown-item">
                                <i class="fas fa-user-plus"></i> Sign Up
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="track-order.php" class="dropdown-item">
                                <i class="fas fa-truck"></i> Track Order
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
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
