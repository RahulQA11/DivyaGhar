<?php
/**
 * Contact Page
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

// Set page meta
$page_title = 'Contact Us - Divyaghar';
$meta_description = 'Get in touch with Divyaghar. Contact us for queries about spiritual items, pooja essentials, and home décor products.';
$meta_keywords = 'contact divyaghar, customer support, spiritual store, contact us';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Validate form data
    $name = clean($_POST['name'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $phone = clean($_POST['phone'] ?? '');
    $subject = clean($_POST['subject'] ?? '');
    $message = clean($_POST['message'] ?? '');
    
    if (empty($name)) $errors['name'] = 'Name is required';
    if (empty($email)) $errors['email'] = 'Email is required';
    elseif (!isValidEmail($email)) $errors['email'] = 'Invalid email address';
    if (empty($subject)) $errors['subject'] = 'Subject is required';
    if (empty($message)) $errors['message'] = 'Message is required';
    
    if (empty($errors)) {
        try {
            // Insert message into database
            $sql = "INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)";
            $db->query($sql, [$name, $email, $phone, $subject, $message]);
            
            // Send email notification (basic implementation)
            $email_subject = "New Contact Message: $subject";
            $email_message = "
                <h2>New Contact Message</h2>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong></p>
                <p>" . nl2br($message) . "</p>
            ";
            
            sendEmail(ADMIN_EMAIL, $email_subject, $email_message);
            
            // Send confirmation email to customer
            $confirmation_subject = "Thank you for contacting Divyaghar";
            $confirmation_message = "
                <h2>Thank you for reaching out!</h2>
                <p>Dear $name,</p>
                <p>We have received your message regarding: <strong>$subject</strong></p>
                <p>Our team will get back to you within 24 hours.</p>
                <p>For urgent queries, call us at +91 98765 43210</p>
                <p>Best regards,<br>Team Divyaghar</p>
            ";
            
            sendEmail($email, $confirmation_subject, $confirmation_message);
            
            setFlashMessage('success', 'Thank you for contacting us! We will get back to you soon.');
            redirect('contact.php');
            
        } catch (Exception $e) {
            $errors['general'] = 'An error occurred while sending your message. Please try again.';
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
        <span>Contact Us</span>
    </div>
</nav>

<!-- Contact Hero Section -->
<section class="contact-hero">
    <div class="container">
        <div class="contact-hero-content">
            <h1>Get in Touch</h1>
            <p>We're here to help you find the perfect spiritual items for your home</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-layout">
            <!-- Contact Form -->
            <div class="contact-form">
                <div class="form-header">
                    <h2>Send us a Message</h2>
                    <p>Have questions about our products or need assistance? We're here to help!</p>
                </div>

                <?php if ($message = getFlashMessage('success')): ?>
                    <div class="alert alert-success"><?php echo $message; ?></div>
                <?php endif; ?>

                <?php if (isset($errors['general'])): ?>
                    <div class="alert alert-error"><?php echo $errors['general']; ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="contact-form-inner">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                            <?php if (isset($errors['name'])): ?>
                                <span class="error"><?php echo $errors['name']; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <span class="error"><?php echo $errors['email']; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($phone ?? ''); ?>" 
                                   pattern="[0-9]{10}" placeholder="10-digit mobile number">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="Product Inquiry" <?php echo (isset($subject) && $subject === 'Product Inquiry') ? 'selected' : ''; ?>>Product Inquiry</option>
                                <option value="Order Status" <?php echo (isset($subject) && $subject === 'Order Status') ? 'selected' : ''; ?>>Order Status</option>
                                <option value="Return/Refund" <?php echo (isset($subject) && $subject === 'Return/Refund') ? 'selected' : ''; ?>>Return/Refund</option>
                                <option value="Bulk Order" <?php echo (isset($subject) && $subject === 'Bulk Order') ? 'selected' : ''; ?>>Bulk Order</option>
                                <option value="Partnership" <?php echo (isset($subject) && $subject === 'Partnership') ? 'selected' : ''; ?>>Partnership</option>
                                <option value="Other" <?php echo (isset($subject) && $subject === 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                            <?php if (isset($errors['subject'])): ?>
                                <span class="error"><?php echo $errors['subject']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="6" 
                                  placeholder="Tell us more about your inquiry..." required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                        <?php if (isset($errors['message'])): ?>
                            <span class="error"><?php echo $errors['message']; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">Send Message</button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="contact-info">
                <div class="info-card">
                    <h3>Get in Touch</h3>
                    <p>Connect with us through any of these channels</p>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="method-icon">📍</div>
                            <div class="method-info">
                                <h4>Visit Our Store</h4>
                                <p>123, Temple Street, Spiritual Nagar, Mumbai - 400001</p>
                                <p>Monday - Saturday: 9:00 AM - 7:00 PM</p>
                                <p>Sunday: 10:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">📞</div>
                            <div class="method-info">
                                <h4>Call Us</h4>
                                <p><a href="tel:+919876543210">+91 98765 43210</a></p>
                                <p><a href="tel:+919876543211">+91 98765 43211</a></p>
                                <p>Available 9:00 AM - 7:00 PM</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">✉️</div>
                            <div class="method-info">
                                <h4>Email Us</h4>
                                <p><a href="mailto:info@divyaghar.com">info@divyaghar.com</a></p>
                                <p><a href="mailto:support@divyaghar.com">support@divyaghar.com</a></p>
                                <p>We respond within 24 hours</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">💬</div>
                            <div class="method-info">
                                <h4>WhatsApp</h4>
                                <p><a href="https://wa.me/919876543210" target="_blank">+91 98765 43210</a></p>
                                <p>Chat with us for quick assistance</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="faq-card">
                    <h3>Frequently Asked Questions</h3>
                    <div class="faq-list">
                        <div class="faq-item">
                            <h4>How long does delivery take?</h4>
                            <p>Standard delivery takes 5-7 business days. Express delivery is available in 2-3 business days.</p>
                        </div>
                        <div class="faq-item">
                            <h4>Do you offer international shipping?</h4>
                            <p>Currently, we ship within India only. We're working on international shipping options.</p>
                        </div>
                        <div class="faq-item">
                            <h4>What is your return policy?</h4>
                            <p>We offer a 7-day return policy for unused items in original packaging.</p>
                        </div>
                        <div class="faq-item">
                            <h4>Are the products authentic?</h4>
                            <p>Yes, all our products are sourced directly from artisans and verified for authenticity.</p>
                        </div>
                        <div class="faq-item">
                            <h4>Do you offer bulk discounts?</h4>
                            <p>Yes, we offer special pricing for bulk orders. Please contact us for details.</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="social-card">
                    <h3>Follow Us</h3>
                    <p>Stay connected for updates and spiritual insights</p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <span class="social-icon">📘</span>
                            <span>Facebook</span>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <span class="social-icon">📷</span>
                            <span>Instagram</span>
                        </a>
                        <a href="#" class="social-link" aria-label="YouTube">
                            <span class="social-icon">📺</span>
                            <span>YouTube</span>
                        </a>
                        <a href="#" class="social-link" aria-label="WhatsApp">
                            <span class="social-icon">💬</span>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <div class="map-header">
            <h2>Find Us</h2>
            <p>Visit our store in Mumbai to experience our collection firsthand</p>
        </div>
        <div class="map-container">
            <div class="map-placeholder">
                <div class="map-content">
                    <div class="map-icon">📍</div>
                    <h3>Divyaghar Store</h3>
                    <p>123, Temple Street, Spiritual Nagar, Mumbai - 400001</p>
                    <a href="https://maps.google.com/?q=Divyaghar+Mumbai" target="_blank" class="btn btn-outline">Get Directions</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
