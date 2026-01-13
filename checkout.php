<?php
/**
 * Checkout Page
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';
require_once 'includes/cart_functions.php';

// Check if cart is empty
$cart_items = getCartItems();
if (empty($cart_items)) {
    setFlashMessage('error', 'Your cart is empty. Please add items before checkout.');
    redirect('cart.php');
}

// Set page meta
$page_title = 'Checkout - Divyaghar';
$meta_description = 'Complete your order at Divyaghar. Secure checkout for spiritual items and home décor.';
$meta_keywords = 'checkout, order, divyaghar, spiritual items, secure payment';

// Get cart totals
$cart_totals = calculateCartTotals();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Validate form data
    $customer_name = clean($_POST['customer_name'] ?? '');
    $customer_email = clean($_POST['customer_email'] ?? '');
    $customer_phone = clean($_POST['customer_phone'] ?? '');
    $shipping_address = clean($_POST['shipping_address'] ?? '');
    $billing_address = clean($_POST['billing_address'] ?? '');
    $payment_method = clean($_POST['payment_method'] ?? 'COD');
    $notes = clean($_POST['notes'] ?? '');
    
    if (empty($customer_name)) $errors['customer_name'] = 'Name is required';
    if (empty($customer_email)) $errors['customer_email'] = 'Email is required';
    elseif (!isValidEmail($customer_email)) $errors['customer_email'] = 'Invalid email address';
    if (empty($customer_phone)) $errors['customer_phone'] = 'Phone is required';
    if (empty($shipping_address)) $errors['shipping_address'] = 'Shipping address is required';
    
    if (empty($errors)) {
        try {
            $db->beginTransaction();
            
            // Generate order number
            $order_number = generateOrderNumber();
            
            // Insert order
            $sql = "INSERT INTO orders (order_number, customer_name, customer_email, customer_phone, 
                    shipping_address, billing_address, subtotal, tax_amount, shipping_amount, 
                    total_amount, payment_method, payment_status, order_status, notes) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $params = [
                $order_number,
                $customer_name,
                $customer_email,
                $customer_phone,
                $shipping_address,
                $billing_address ?: $shipping_address,
                $cart_totals['subtotal'],
                $cart_totals['tax_amount'],
                $cart_totals['shipping_amount'],
                $cart_totals['total_amount'],
                $payment_method,
                'pending',
                'pending',
                $notes
            ];
            
            $db->query($sql, $params);
            $order_id = $db->lastInsertId();
            
            // Insert order items
            foreach ($cart_items as $item) {
                $sql = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price, total) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                
                $item_total = $item['price'] * $item['quantity'];
                $db->query($sql, [$order_id, $item['id'], $item['name'], $item['quantity'], $item['price'], $item_total]);
                
                // Update product stock
                $db->query("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?", 
                          [$item['quantity'], $item['id']]);
            }
            
            $db->commit();
            
            // Clear cart
            clearCart();
            
            // Send order confirmation email (basic implementation)
            $email_subject = "Order Confirmation - Divyaghar (Order #$order_number)";
            $email_message = "
                <h2>Thank you for your order!</h2>
                <p>Order Number: <strong>$order_number</strong></p>
                <p>Total Amount: <strong>" . formatPrice($cart_totals['total_amount']) . "</strong></p>
                <p>We'll process your order and send you updates via email.</p>
                <p>For any queries, contact us at info@divyaghar.com</p>
            ";
            
            sendEmail($customer_email, $email_subject, $email_message);
            
            // Redirect to order confirmation
            setFlashMessage('success', 'Order placed successfully! Order number: ' . $order_number);
            redirect('order_confirmation.php?order=' . $order_number);
            
        } catch (Exception $e) {
            $db->rollback();
            $errors['general'] = 'An error occurred while processing your order. Please try again.';
        }
    }
}

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<nav class="breadcrumb">
    <div class="container">
        <a href="index.php">Home</a>
        <span>›</span>
        <a href="cart.php">Shopping Cart</a>
        <span>›</span>
        <span>Checkout</span>
    </div>
</nav>

<!-- Checkout Section -->
<section class="checkout-section">
    <div class="container">
        <div class="checkout-header">
            <h1>Checkout</h1>
            <p>Complete your order to bring divinity home</p>
        </div>

        <?php if ($message = getFlashMessage('error')): ?>
            <div class="alert alert-error"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (isset($errors['general'])): ?>
            <div class="alert alert-error"><?php echo $errors['general']; ?></div>
        <?php endif; ?>

        <div class="checkout-layout">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form method="POST" action="" id="checkoutForm">
                    <div class="checkout-sections">
                        <!-- Customer Information -->
                        <div class="checkout-section">
                            <h3>Customer Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="customer_name">Full Name *</label>
                                    <input type="text" id="customer_name" name="customer_name" 
                                           value="<?php echo htmlspecialchars($customer_name ?? ''); ?>" required>
                                    <?php if (isset($errors['customer_name'])): ?>
                                        <span class="error"><?php echo $errors['customer_name']; ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="customer_email">Email Address *</label>
                                    <input type="email" id="customer_email" name="customer_email" 
                                           value="<?php echo htmlspecialchars($customer_email ?? ''); ?>" required>
                                    <?php if (isset($errors['customer_email'])): ?>
                                        <span class="error"><?php echo $errors['customer_email']; ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="customer_phone">Phone Number *</label>
                                    <input type="tel" id="customer_phone" name="customer_phone" 
                                           value="<?php echo htmlspecialchars($customer_phone ?? ''); ?>" 
                                           pattern="[0-9]{10}" placeholder="10-digit mobile number" required>
                                    <?php if (isset($errors['customer_phone'])): ?>
                                        <span class="error"><?php echo $errors['customer_phone']; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="checkout-section">
                            <h3>Shipping Address</h3>
                            <div class="form-group">
                                <label for="shipping_address">Complete Address *</label>
                                <textarea id="shipping_address" name="shipping_address" rows="4" 
                                          placeholder="House No., Street, Area, City, State, PIN Code" required><?php echo htmlspecialchars($shipping_address ?? ''); ?></textarea>
                                <?php if (isset($errors['shipping_address'])): ?>
                                    <span class="error"><?php echo $errors['shipping_address']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="checkout-section">
                            <h3>Billing Address</h3>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" id="same_as_shipping" name="same_as_shipping" 
                                           checked onchange="toggleBillingAddress()">
                                    Same as shipping address
                                </label>
                            </div>
                            <div class="form-group" id="billing_address_group" style="display: none;">
                                <label for="billing_address">Billing Address</label>
                                <textarea id="billing_address" name="billing_address" rows="4" 
                                          placeholder="House No., Street, Area, City, State, PIN Code"><?php echo htmlspecialchars($billing_address ?? ''); ?></textarea>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="checkout-section">
                            <h3>Payment Method</h3>
                            <div class="payment-options">
                                <div class="payment-option">
                                    <label>
                                        <input type="radio" name="payment_method" value="COD" checked>
                                        <span class="payment-icon">💰</span>
                                        <div class="payment-info">
                                            <strong>Cash on Delivery</strong>
                                            <p>Pay when you receive your order</p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="payment-option disabled">
                                    <label>
                                        <input type="radio" name="payment_method" value="Online" disabled>
                                        <span class="payment-icon">💳</span>
                                        <div class="payment-info">
                                            <strong>Online Payment</strong>
                                            <p>Credit/Debit Card, UPI, NetBanking (Coming Soon)</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="checkout-section">
                            <h3>Order Notes (Optional)</h3>
                            <div class="form-group">
                                <label for="notes">Special instructions for your order</label>
                                <textarea id="notes" name="notes" rows="3" 
                                          placeholder="Any special delivery instructions or gift messages..."><?php echo htmlspecialchars($notes ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-actions">
                        <a href="cart.php" class="btn btn-secondary">← Back to Cart</a>
                        <button type="submit" class="btn btn-primary btn-large">Place Order</button>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="checkout-summary">
                <div class="summary-card">
                    <h3>Order Summary</h3>
                    
                    <div class="order-items">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="summary-item">
                                <div class="summary-item-info">
                                    <span class="item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                    <span class="item-quantity">× <?php echo $item['quantity']; ?></span>
                                </div>
                                <span class="item-price"><?php echo formatPrice($item['price'] * $item['quantity']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span><?php echo formatPrice($cart_totals['subtotal']); ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Tax (18% GST)</span>
                        <span><?php echo formatPrice($cart_totals['tax_amount']); ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>
                            <?php if ($cart_totals['shipping_amount'] == 0): ?>
                                <span class="free-shipping">FREE</span>
                            <?php else: ?>
                                <?php echo formatPrice($cart_totals['shipping_amount']); ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span><?php echo formatPrice($cart_totals['total_amount']); ?></span>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="trust-badges">
                    <h4>Why shop with us?</h4>
                    <div class="trust-item">
                        <span class="trust-icon">🔒</span>
                        <span>100% Secure Checkout</span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-icon">🚚</span>
                        <span>Fast & Safe Delivery</span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-icon">🏆</span>
                        <span>Premium Quality Products</span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-icon">🤝</span>
                        <span>Excellent Customer Support</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script>
function toggleBillingAddress() {
    const checkbox = document.getElementById('same_as_shipping');
    const billingGroup = document.getElementById('billing_address_group');
    const billingTextarea = document.getElementById('billing_address');
    
    if (checkbox.checked) {
        billingGroup.style.display = 'none';
        billingTextarea.required = false;
    } else {
        billingGroup.style.display = 'block';
        billingTextarea.required = true;
    }
}

// Form validation
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const phone = document.getElementById('customer_phone').value;
    if (phone && !/^[0-9]{10}$/.test(phone)) {
        e.preventDefault();
        alert('Please enter a valid 10-digit phone number');
        return false;
    }
});
</script>
