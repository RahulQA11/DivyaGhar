<?php
/**
 * Order Confirmation Page
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

// Get order number from URL
$order_number = $_GET['order'] ?? '';

if (empty($order_number)) {
    redirect('index.php');
}

// Get order details
$order = $db->fetch("SELECT * FROM orders WHERE order_number = ?", [$order_number]);

if (!$order) {
    setFlashMessage('error', 'Order not found');
    redirect('index.php');
}

// Get order items
$order_items = $db->fetchAll("SELECT * FROM order_items WHERE order_id = ? ORDER BY id ASC", [$order['id']]);

// Set page meta
$page_title = 'Order Confirmation - Divyaghar';
$meta_description = 'Your order has been placed successfully at Divyaghar. Thank you for choosing our spiritual items.';
$meta_keywords = 'order confirmation, divyaghar, spiritual items, thank you';

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<nav class="breadcrumb">
    <div class="container">
        <a href="index.php">Home</a>
        <span>›</span>
        <span>Order Confirmation</span>
    </div>
</nav>

<!-- Order Confirmation Section -->
<section class="order-confirmation">
    <div class="container">
        <div class="confirmation-header">
            <div class="success-icon">✓</div>
            <h1>Order Placed Successfully!</h1>
            <p>Thank you for choosing Divyaghar for your spiritual needs</p>
        </div>

        <div class="confirmation-layout">
            <!-- Order Details -->
            <div class="order-details">
                <div class="detail-card">
                    <h3>Order Information</h3>
                    <div class="order-info-grid">
                        <div class="info-item">
                            <span class="label">Order Number:</span>
                            <span class="value order-number"><?php echo htmlspecialchars($order['order_number']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="label">Order Date:</span>
                            <span class="value"><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="label">Payment Method:</span>
                            <span class="value"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="label">Order Status:</span>
                            <span class="value">
                                <span class="status status-<?php echo $order['order_status']; ?>">
                                    <?php echo ucfirst($order['order_status']); ?>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="detail-card">
                    <h3>Customer Information</h3>
                    <div class="customer-info">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                    </div>
                </div>

                <div class="detail-card">
                    <h3>Shipping Address</h3>
                    <div class="address-info">
                        <p><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                    </div>
                </div>

                <div class="detail-card">
                    <h3>Order Items</h3>
                    <div class="order-items-list">
                        <?php foreach ($order_items as $item): ?>
                            <div class="order-item">
                                <div class="item-info">
                                    <span class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></span>
                                    <span class="item-quantity">Quantity: <?php echo $item['quantity']; ?></span>
                                </div>
                                <span class="item-price"><?php echo formatPrice($item['total']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="detail-card">
                    <h3>Order Summary</h3>
                    <div class="order-summary">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span><?php echo formatPrice($order['subtotal']); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (18% GST):</span>
                            <span><?php echo formatPrice($order['tax_amount']); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping:</span>
                            <span>
                                <?php if ($order['shipping_amount'] == 0): ?>
                                    <span class="free-shipping">FREE</span>
                                <?php else: ?>
                                    <?php echo formatPrice($order['shipping_amount']); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="summary-row total-row">
                            <strong>Total Amount:</strong>
                            <strong><?php echo formatPrice($order['total_amount']); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="next-steps">
                <div class="steps-card">
                    <h3>What's Next?</h3>
                    <div class="steps-list">
                        <div class="step-item">
                            <div class="step-icon">📧</div>
                            <div class="step-content">
                                <h4>Order Confirmation</h4>
                                <p>We've sent a confirmation email to <?php echo htmlspecialchars($order['customer_email']); ?></p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-icon">🏭</div>
                            <div class="step-content">
                                <h4>Order Processing</h4>
                                <p>Your order will be processed within 24 hours</p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-icon">🚚</div>
                            <div class="step-content">
                                <h4>Shipping</h4>
                                <p>You'll receive your order within 5-7 business days</p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-icon">📞</div>
                            <div class="step-content">
                                <h4>Track Your Order</h4>
                                <p>Contact us at +91 98765 43210 for order updates</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="actions-card">
                    <h3>Continue Shopping</h3>
                    <p>Explore more spiritual items for your home</p>
                    <div class="action-buttons">
                        <a href="products.php" class="btn btn-primary">Browse Products</a>
                        <a href="index.php" class="btn btn-outline">Back to Home</a>
                    </div>
                </div>

                <div class="contact-card">
                    <h3>Need Help?</h3>
                    <p>Our customer support team is here to assist you</p>
                    <div class="contact-info">
                        <p>📧 <a href="mailto:info@divyaghar.com">info@divyaghar.com</a></p>
                        <p>📞 <a href="tel:+919876543210">+91 98765 43210</a></p>
                        <p>🕐 Mon-Sat: 9:00 AM - 7:00 PM</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Information -->
        <div class="important-info">
            <div class="info-card">
                <h3>Important Information</h3>
                <ul>
                    <li>Please keep your order number (<strong><?php echo $order['order_number']; ?></strong>) for future reference</li>
                    <li>For Cash on Delivery orders, please keep the exact amount ready</li>
                    <li>Our delivery partner will call you before delivery</li>
                    <li>Please inspect your items carefully before accepting the delivery</li>
                    <li>In case of any issues, contact us within 7 days of delivery</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Thank You Section -->
<section class="thank-you-section">
    <div class="container">
        <div class="thank-you-content">
            <h2>Thank You for Choosing Divyaghar!</h2>
            <p>We appreciate your trust in our products. May these spiritual items bring peace and positivity to your home.</p>
            <div class="blessing-message">
                <p>"ॐ सर्वे भवन्तु सुखिनः" - May all be happy and prosperous</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
