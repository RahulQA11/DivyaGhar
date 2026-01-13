<?php
/**
 * Enhanced Shopping Cart Page
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';
require_once 'includes/cart_functions.php';

// Set page meta
$page_title = 'Shopping Cart - Divyaghar';
$meta_description = 'Review and manage your shopping cart at Divyaghar. High-quality spiritual items and home décor.';
$meta_keywords = 'shopping cart, divyaghar, spiritual items, pooja essentials';

// Get cart items and totals
$cart_items = getCartItems();
$cart_totals = calculateCartTotals();

include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS with Cache Busting -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/cart.css?v=<?php echo time(); ?>">
    <style>
        /* Force Perfect Table Structure with Percentage Widths */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            text-align: left !important;
            width: 35% !important;
        }
        .table th:nth-child(2),
        .table td:nth-child(2) {
            text-align: center !important;
            width: 15% !important;
            font-weight: 700 !important;
        }
        .table th:nth-child(3),
        .table td:nth-child(3) {
            text-align: center !important;
            width: 15% !important;
        }
        .table th:nth-child(4),
        .table td:nth-child(4) {
            text-align: center !important;
            width: 20% !important;
            font-weight: 700 !important;
        }
        .table th:nth-child(5),
        .table td:nth-child(5) {
            text-align: center !important;
            width: 15% !important;
        }
    </style>
</head>
<body>
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <div class="container">
            <a href="index.php" class="breadcrumb-item">
                <i class="fas fa-home"></i>
                Home
            </a>
            <span class="breadcrumb-separator">›</span>
            <span class="breadcrumb-current">Shopping Cart</span>
        </div>
    </nav>

    <!-- Cart Header -->
    <section class="cart-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="cart-title">
                        <i class="fas fa-shopping-cart"></i>
                        Your Shopping Cart
                        <span class="cart-count">(<?php echo $cart_totals['total_items']; ?> items)</span>
                    </h1>
                </div>
                <div class="col-md-4 text-end">
                    <a href="products.php" class="btn btn-outline">
                        <i class="fas fa-plus"></i>
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart Content -->
    <section class="cart-content">
        <div class="container">
            <?php if ($message = getFlashMessage('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if ($message = getFlashMessage('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (empty($cart_items)): ?>
                <!-- Empty Cart -->
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2>Your cart is empty</h2>
                    <p>Looks like you haven't added any spiritual items to your cart yet.</p>
                    <div class="empty-cart-actions">
                        <a href="products.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i>
                            Browse Products
                        </a>
                        <a href="categories.php" class="btn btn-outline btn-lg">
                            <i class="fas fa-th-large"></i>
                            View Categories
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Cart Items Table -->
                <div class="cart-items-container">
                    <div class="row">
                        <div class="col-12">
                            <div class="cart-items-table">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cart_items as $item): ?>
                                                <tr class="cart-item-row" data-product-id="<?php echo $item['id']; ?>">
                                                    <td>
                                                        <div class="product-info">
                                                            <div class="product-image">
                                                                <?php if ($item['primary_image']): ?>
                                                                    <img src="<?php echo SITE_URL; ?>uploads/<?php echo $item['primary_image']; ?>" 
                                                                         alt="<?php echo htmlspecialchars($item['name']); ?>">
                                                                <?php else: ?>
                                                                    <img src="<?php echo SITE_URL; ?>assets/images/placeholder-product.jpg" 
                                                                         alt="<?php echo htmlspecialchars($item['name']); ?>">
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="product-details">
                                                                <h5>
                                                                    <a href="product.php?slug=<?php echo $item['slug']; ?>">
                                                                        <?php echo htmlspecialchars($item['name']); ?>
                                                                    </a>
                                                                </h5>
                                                                <p class="product-category">
                                                                    <a href="category.php?slug=<?php echo $item['category_slug']; ?>">
                                                                        <i class="fas fa-tag"></i>
                                                                        <?php echo htmlspecialchars($item['category_name']); ?>
                                                                    </a>
                                                                </p>
                                                                <div class="product-price">
                                                                    <div class="product-price">
                                                                    <span class="current-price"><?php echo formatPrice($item['price']); ?></span>
                                                                    <?php if (!empty($item['discount_price'])): ?>
                                                                        <span class="original-price"><?php echo formatPrice($item['price']); ?></span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="quantity-controls">
                                                            <button type="button" class="btn btn-sm btn-outline quantity-btn" 
                                                                    onclick="updateQuantity(<?php echo $item['id']; ?>, -1)">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" class="quantity-input" 
                                                                   value="<?php echo $item['quantity']; ?>" 
                                                                   min="1" 
                                                                   max="<?php echo $item['stock_quantity']; ?>"
                                                                   onchange="updateQuantity(<?php echo $item['id']; ?>, this.value)">
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-outline quantity-btn" 
                                                                    onclick="updateQuantity(<?php echo $item['id']; ?>, 1)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <strong><?php echo formatPrice($item['price'] * $item['quantity']); ?></strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-danger" 
                                                                onclick="removeFromCart(<?php echo $item['id']; ?>)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
        </div>
    </section>

    <!-- Cart Summary -->
    <?php if (!empty($cart_items)): ?>
        <section class="cart-summary">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Order Summary</h2>
                    </div>
                    <div class="col-md-4">
                        <a href="checkout.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-credit-card"></i>
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
                
                <div class="summary-cards">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="summary-card">
                                <div class="summary-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="summary-content">
                                    <h3>Subtotal</h3>
                                    <p><?php echo formatPrice($cart_totals['subtotal']); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="summary-card">
                                <div class="summary-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="summary-content">
                                    <h3>Tax (18% GST)</h3>
                                    <p><?php echo formatPrice($cart_totals['tax_amount']); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="summary-card">
                                <div class="summary-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="summary-content">
                                    <h3>Shipping</h3>
                                    <p><?php 
                                        if ($cart_totals['shipping_amount'] == 0) {
                                            echo 'FREE';
                                        } else {
                                            echo formatPrice($cart_totals['shipping_amount']);
                                        }
                                    ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="summary-card">
                                <div class="summary-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div class="summary-content">
                                    <h3>Total</h3>
                                    <p><?php echo formatPrice($cart_totals['total_amount']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Continue Shopping -->
    <section class="continue-shopping">
        <div class="container">
            <div class="text-center">
                <h3>Continue Shopping</h3>
                <p>Discover more spiritual items and home décor</p>
                <div class="continue-shopping-actions">
                    <a href="products.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-search"></i>
                        Browse All Products
                    </a>
                    <a href="categories.php" class="btn btn-outline btn-lg">
                        <i class="fas fa-th-large"></i>
                        View Categories
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Badges -->
    <section class="trust-badges">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="trust-item">
                        <div class="trust-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="trust-content">
                            <h4>Secure Payment</h4>
                            <p>Your payment information is safe and encrypted</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="trust-item">
                        <div class="trust-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="trust-content">
                            <h4>Fast Delivery</h4>
                            <p>Quick delivery across India</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="trust-item">
                        <div class="trust-icon">
                            <i class="fas fa-undo"></i>
                        </div>
                        <div class="trust-content">
                            <h4>Easy Returns</h4>
                            <p>30-day return policy</p>
                        </div>
                    </div>
                
                <div class="col-md-3">
                    <div class="trust-item">
                        <div class="trust-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="trust-content">
                            <h4>24/7 Support</h4>
                            <p>Always here to help you</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQuantity(productId, change) {
            const input = document.querySelector(`input[data-product-id="${productId}"]`);
            if (input) {
                const newQuantity = parseInt(input.value) + change;
                if (newQuantity >= 1 && newQuantity <= parseInt(input.max)) {
                    input.value = newQuantity;
                    // Update cart via AJAX
                    fetch('cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: `action=update&product_id=${productId}&quantity=${newQuantity}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update total amount
                            updateCartTotals();
                            // Show success message
                            showNotification('success', data.message);
                        } else {
                            showNotification('error', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating cart:', error);
                        showNotification('error', 'Error updating cart');
                    });
                }
            }
        }

        function removeFromCart(productId) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `action=remove&product_id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove row from table
                        const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                        if (row) {
                            row.style.transition = 'all 0.3s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(-20px)';
                            setTimeout(() => {
                                row.remove();
                                updateCartTotals();
                                showNotification('success', data.message);
                            }, 300);
                        }
                    } else {
                        showNotification('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error removing from cart:', error);
                    showNotification('error', 'Error removing item');
                });
            }
        }

        function updateCartTotals() {
            // Reload cart totals via AJAX
            fetch('cart.php?action=totals')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update subtotal
                        const subtotalElement = document.querySelector('.summary-card:nth-child(1) p');
                        if (subtotalElement) {
                            subtotalElement.textContent = data.subtotal;
                        }
                        
                        // Update tax
                        const taxElement = document.querySelector('.summary-card:nth-child(2) p');
                        if (taxElement) {
                            taxElement.textContent = data.tax;
                        }
                        
                        // Update shipping
                        const shippingElement = document.querySelector('.summary-card:nth-child(3) p');
                        if (shippingElement) {
                            shippingElement.textContent = data.shipping;
                        }
                        
                        // Update total
                        const totalElement = document.querySelector('.summary-card:nth-child(4) p');
                        if (totalElement) {
                            totalElement.textContent = data.total;
                        }
                        
                        // Update cart count
                        const cartCountElement = document.querySelector('.cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = `(${data.total_items})`;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error updating totals:', error);
                });
        }

        function showNotification(type, message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show`;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()">
                    <span>&times;</span>
                </button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        }

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>
