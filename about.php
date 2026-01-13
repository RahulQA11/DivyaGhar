<?php
/**
 * About Us Page
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

// Set page meta
$page_title = 'About Us - Divyaghar';
$meta_description = 'Learn about Divyaghar - Your trusted destination for high-quality pooja essentials, home décor, god idols, and spiritual gifts since 2020.';
$meta_keywords = 'about divyaghar, spiritual store, pooja essentials, home decor, about us';

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<nav class="breadcrumb">
    <div class="container">
        <a href="index.php">Home</a>
        <span>›</span>
        <span>About Us</span>
    </div>
</nav>

<!-- About Hero Section -->
<section class="about-hero">
    <div class="container">
        <div class="about-hero-content">
            <h1>Our Story</h1>
            <p class="hero-subtitle">Bringing divinity and spirituality into every home</p>
            <div class="hero-description">
                <p>Founded in 2020, Divyaghar emerged from a simple yet profound vision: to make authentic spiritual items and traditional home décor accessible to every household seeking peace, prosperity, and divine connection.</p>
            </div>
        </div>
        <div class="about-hero-image">
            <img src="<?php echo SITE_URL; ?>assets/images/about-hero.jpg" alt="Divyaghar Story">
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="mission-section">
    <div class="container">
        <div class="section-header">
            <h2>Our Mission</h2>
            <p>Guided by tradition, dedicated to quality</p>
        </div>
        <div class="mission-content">
            <div class="mission-text">
                <p>At Divyaghar, we are committed to preserving the rich heritage of Indian spiritual traditions while making them relevant to modern homes. Our mission is to:</p>
                <ul class="mission-list">
                    <li>Provide authentic, high-quality spiritual items sourced from skilled artisans</li>
                    <li>Promote spiritual well-being and positive energy in every home</li>
                    <li>Make traditional pooja essentials accessible to all generations</li>
                    <li>Support local artisans and preserve traditional craftsmanship</li>
                    <li>Create a seamless online shopping experience for spiritual products</li>
                </ul>
            </div>
            <div class="mission-visual">
                <div class="stat-card">
                    <div class="stat-number">50,000+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Spiritual Products</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Artisan Partners</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">4.8★</div>
                    <div class="stat-label">Customer Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="section-header">
            <h2>Our Values</h2>
            <p>The principles that guide everything we do</p>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🙏</div>
                <h3>Authenticity</h3>
                <p>Every product is carefully selected for its authenticity and traditional significance, ensuring genuine spiritual value for our customers.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">✨</div>
                <h3>Quality</h3>
                <p>We never compromise on quality. Each item undergoes strict quality checks to ensure it meets our high standards of craftsmanship and durability.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3>Trust</h3>
                <p>Built on transparency and integrity, we strive to earn and maintain the trust of every customer through honest business practices.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🌱</div>
                <h3>Sustainability</h3>
                <p>We support eco-friendly practices and work with artisans who use sustainable materials, respecting both tradition and environment.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <div class="section-header">
            <h2>Meet Our Team</h2>
            <p>The passionate people behind Divyaghar</p>
        </div>
        <div class="team-grid">
            <div class="team-member">
                <div class="member-image">
                    <img src="<?php echo SITE_URL; ?>assets/images/team/founder.jpg" alt="Founder">
                </div>
                <div class="member-info">
                    <h3>Rajesh Sharma</h3>
                    <p class="member-title">Founder & CEO</p>
                    <p class="member-bio">With over 15 years in spiritual retail, Rajesh envisioned Divyaghar to bridge tradition with modern convenience.</p>
                </div>
            </div>
            <div class="team-member">
                <div class="member-image">
                    <img src="<?php echo SITE_URL; ?>assets/images/team/manager.jpg" alt="Manager">
                </div>
                <div class="member-info">
                    <h3>Priya Nair</h3>
                    <p class="member-title">Operations Manager</p>
                    <p class="member-bio">Priya ensures every order is handled with care and reaches customers with the divine blessings it carries.</p>
                </div>
            </div>
            <div class="team-member">
                <div class="member-image">
                    <img src="<?php echo SITE_URL; ?>assets/images/team/designer.jpg" alt="Designer">
                </div>
                <div class="member-info">
                    <h3>Amit Patel</h3>
                    <p class="member-title">Product Curator</p>
                    <p class="member-bio">Amit travels across India to discover unique spiritual items and connect with traditional artisans.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="process-section">
    <div class="container">
        <div class="section-header">
            <h2>How We Work</h2>
            <p>From selection to delivery, our commitment to excellence</p>
        </div>
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Artisan Selection</h3>
                    <p>We partner with skilled artisans who have inherited traditional craftsmanship through generations.</p>
                </div>
            </div>
            <div class="process-step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Quality Assurance</h3>
                    <p>Each product undergoes rigorous quality checks to ensure it meets our standards of authenticity and excellence.</p>
                </div>
            </div>
            <div class="process-step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Spiritual Blessing</h3>
                    <p>Many of our items receive traditional blessings before being made available to our customers.</p>
                </div>
            </div>
            <div class="process-step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3>Secure Packaging</h3>
                    <p>We use eco-friendly, secure packaging to ensure your spiritual items reach you safely and beautifully.</p>
                </div>
            </div>
            <div class="process-step">
                <div class="step-number">5</div>
                <div class="step-content">
                    <h3>Timely Delivery</h3>
                    <p>Our delivery partners ensure your order reaches you with care and respect for the sacred nature of the items.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <h2>What Our Customers Say</h2>
            <p>Real experiences from our spiritual community</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>"Divyaghar has transformed my home into a spiritual sanctuary. The quality of their brass idols is exceptional, and the packaging was so thoughtful."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-info">
                        <h4>Anjali Reddy</h4>
                        <span>Bangalore</span>
                    </div>
                    <div class="rating">★★★★★</div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>"I've been buying from Divyaghar for two years now. Their pooja thalis and incense sticks are authentic and reasonably priced. Highly recommended!"</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-info">
                        <h4>Ramesh Kumar</h4>
                        <span>Delhi</span>
                    </div>
                    <div class="rating">★★★★★</div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>"The customer service is outstanding. They helped me choose the perfect Ganesh idol for my new home. The item arrived beautifully packaged and on time."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-info">
                        <h4>Sneha Patel</h4>
                        <span>Mumbai</span>
                    </div>
                    <div class="rating">★★★★★</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Join Our Spiritual Community</h2>
            <p>Subscribe to receive updates on new arrivals, spiritual insights, and exclusive offers</p>
            <div class="cta-actions">
                <a href="products.php" class="btn btn-primary btn-large">Explore Our Collection</a>
                <a href="contact.php" class="btn btn-outline btn-large">Get in Touch</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
