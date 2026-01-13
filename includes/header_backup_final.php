<?php
/**
 * Header Component - Clean MDB5 Version
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
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Divyaghar'; ?> - Premium Spiritual & Home Décor</title>
    
    <?php if (isset($meta_description)): ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php else: ?>
    <meta name="description" content="Divyaghar - High-quality pooja essentials, home décor, god idols, and spiritual gifts. Bring divinity home with our premium collection.">
    <?php endif; ?>
    
    <?php if (isset($meta_keywords)): ?>
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <?php else: ?>
    <meta name="keywords" content="pooja essentials, home decor, god idols, spiritual gifts, divyaghar, brass items, sandalwood, incense">
    <?php endif; ?>
    
    <meta name="author" content="Divyaghar">
    <meta property="og:title" content="<?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Divyaghar'; ?>">
    <meta property="og:description" content="High-quality pooja essentials, home décor, god idols, and spiritual gifts">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>assets/images/logo.png">
    
    <!-- MDB5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.3.0/mdb.min.css" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>assets/images/favicon.ico">
    
    <!-- Custom Styles -->
    <style>
        /* Brand Colors */
        :root {
            --primary-color: #800000;
            --secondary-color: #D2B48C;
            --accent-color: #CFB53B;
            --dark-color: #1a1a1a;
        }
        
        /* Override MDB5 Colors */
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        
        .btn-primary:hover {
            background-color: #5c0000 !important;
            border-color: #5c0000 !important;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .navbar-brand {
            color: var(--primary-color) !important;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        .dropdown-item:hover {
            background-color: #f5e6d3;
            color: var(--primary-color) !important;
        }
        
        /* Hero Section */
        .hero-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, #5c0000 100%) !important;
        }
        
        /* Card Styles */
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none !important;
        }
        
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        
        /* Typography */
        .display-2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        .lead {
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
        }
        
        /* Navbar */
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-light .navbar-nav .nav-link {
            font-weight: 500;
            margin: 0 0.5rem;
        }
        
        /* Search Box */
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.25);
        }
        
        /* Footer */
        footer {
            background-color: var(--dark-color) !important;
        }
        
        footer h5 {
            color: #fff !important;
            font-weight: 600;
        }
        
        footer .text-white-50:hover {
            color: #fff !important;
            transition: color 0.3s ease;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }
            
            .d-flex {
                justify-content: center !important;
            }
        }
    </style>
</head>
<body>

<!-- MDB5 Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="<?php echo SITE_URL; ?>assets/images/logo.svg" alt="Divyaghar" height="40" class="me-2">
            <span>Divyaghar</span>
        </a>
        
        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'active' : ''; ?>" href="index.php">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                
                <!-- Categories Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown">
                        <i class="fas fa-th-large me-1"></i> Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a class="dropdown-item" href="category.php?slug=<?php echo $category['slug']; ?>">
                                    <i class="fas fa-tag me-2"></i><?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'products.php') ? 'active' : ''; ?>" href="products.php">
                        <i class="fas fa-shopping-bag me-1"></i> All Products
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'about.php') ? 'active' : ''; ?>" href="about.php">
                        <i class="fas fa-info-circle me-1"></i> About
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'contact.php') ? 'active' : ''; ?>" href="contact.php">
                        <i class="fas fa-envelope me-1"></i> Contact
                    </a>
                </li>
            </ul>
            
            <!-- Right side items -->
            <div class="d-flex align-items-center">
                <!-- Search -->
                <form class="input-group me-3" action="search.php" method="GET">
                    <input type="text" class="form-control" name="q" placeholder="Search products..." aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <!-- Cart -->
                <div class="dropdown">
                    <a class="btn btn-primary position-relative me-3" href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if ($cart_count > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo $cart_count; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </div>
                
                <!-- User Account -->
                <div class="dropdown">
                    <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-mdb-toggle="dropdown">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="login.php"><i class="fas fa-sign-in-alt me-2"></i> Login</a></li>
                        <li><a class="dropdown-item" href="register.php"><i class="fas fa-user-plus me-2"></i> Register</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="orders.php"><i class="fas fa-box me-2"></i> My Orders</a></li>
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-cog me-2"></i> Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
