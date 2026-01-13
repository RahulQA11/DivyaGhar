<?php
/**
 * Footer Component - Clean MDB5 Version
 * Divyaghar E-commerce Website
 */
?>

<!-- MDB5 Footer -->
<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="<?php echo SITE_URL; ?>assets/images/logo.svg" alt="Divyaghar" height="40" class="me-2">
                    <h3 class="fw-bold mb-0" style="font-family: 'Playfair Display', serif;">Divyaghar</h3>
                </div>
                <p class="mb-3">
                    Bringing divinity to your home with premium quality pooja essentials, 
                    spiritual décor, and sacred items crafted for sacred living.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white fs-5"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="index.php" class="text-white-50 text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="products.php" class="text-white-50 text-decoration-none">All Products</a></li>
                    <li class="mb-2"><a href="about.php" class="text-white-50 text-decoration-none">About Us</a></li>
                    <li class="mb-2"><a href="contact.php" class="text-white-50 text-decoration-none">Contact</a></li>
                    <li class="mb-2"><a href="privacy.php" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
                    <li class="mb-2"><a href="terms.php" class="text-white-50 text-decoration-none">Terms & Conditions</a></li>
                </ul>
            </div>
            
            <!-- Categories -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="fw-bold mb-3">Categories</h5>
                <ul class="list-unstyled">
                    <?php 
                    $footer_categories = $db->fetchAll("SELECT id, name, slug FROM categories WHERE status = 'active' ORDER BY name ASC LIMIT 6");
                    foreach ($footer_categories as $category): 
                    ?>
                        <li class="mb-2">
                            <a href="category.php?slug=<?php echo $category['slug']; ?>" class="text-white-50 text-decoration-none">
                                <i class="fas fa-tag me-2"></i><?php echo htmlspecialchars($category['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="fw-bold mb-3">Contact Info</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        123, Temple Street, Spiritual Nagar, Mumbai - 400001
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        +91 98765 43210
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        info@divyaghar.com
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-clock me-2"></i>
                        Mon-Sat: 9:00 AM - 7:00 PM
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-clock me-2"></i>
                        Sunday: 10:00 AM - 5:00 PM
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Payment Methods & Copyright -->
        <hr class="border-white border-opacity-25 my-4">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
                    <span class="text-white-50">Payment Methods:</span>
                    <div class="d-flex gap-2">
                        <i class="fab fa-cc-visa fs-5"></i>
                        <i class="fab fa-cc-mastercard fs-5"></i>
                        <i class="fab fa-cc-paypal fs-5"></i>
                        <i class="fab fa-google-pay fs-5"></i>
                        <i class="fas fa-university fs-5"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-white-50">
                    &copy; <?php echo date('Y'); ?> Divyaghar. All rights reserved. | 
                    <i class="fas fa-heart text-danger"></i> Crafted for spiritual living
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- MDB5 JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.3.0/mdb.min.js"></script>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<!-- Custom JavaScript -->
<script src="<?php echo SITE_URL; ?>assets/js/script.js"></script>

<!-- Back to Top Button -->
<button class="btn btn-primary btn-floating btn-lg back-to-top" id="back-to-top" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; display: none;">
    <i class="fas fa-arrow-up"></i>
</button>

</body>
</html>
