<?php
/**
 * Professional Footer Component
 * Divyaghar E-commerce Website
 */
?>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-logo">
                    <img src="<?php echo SITE_URL; ?>assets/images/logo.svg" alt="Divyaghar">
                    <h3>Divyaghar</h3>
                </div>
                <p class="footer-description">
                    Bringing divinity to your home with premium quality pooja essentials, 
                    spiritual décor, and sacred items crafted for sacred living.
                </p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">All Products</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Categories</h4>
                <ul>
                    <?php 
                    $footer_categories = $db->fetchAll("SELECT id, name, slug FROM categories WHERE status = 'active' ORDER BY name ASC LIMIT 6");
                    foreach ($footer_categories as $category): 
                    ?>
                        <li><a href="category.php?slug=<?php echo $category['slug']; ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Contact Info</h4>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> 123, Temple Street, Spiritual Nagar, Mumbai - 400001</p>
                    <p><i class="fas fa-phone"></i> +91 98765 43210</p>
                    <p><i class="fas fa-envelope"></i> info@divyaghar.com</p>
                    <p><i class="fas fa-clock"></i> Mon-Sat: 9:00 AM - 7:00 PM</p>
                    <p><i class="fas fa-clock"></i> Sunday: 10:00 AM - 5:00 PM</p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="payment-methods">
                <span>Payment Methods:</span>
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-paypal"></i>
                <i class="fab fa-google-pay"></i>
                <i class="fas fa-university"></i>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> Divyaghar. All rights reserved. | Crafted with ❤️ for spiritual living</p>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button class="back-to-top" id="back-to-top">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script src="<?php echo SITE_URL; ?>assets/js/professional.js"></script>

</body>
</html>
