<?php
/**
 * About Us Page - Premium Design
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';

// Set page meta
$page_title = 'About Us - Divyaghar';
$meta_description = 'Learn about Divyaghar - Your trusted destination for high-quality pooja essentials, home décor, god idols, and spiritual gifts since 2020.';
$meta_keywords = 'about divyaghar, spiritual store, pooja essentials, home decor, about us';

include 'includes/header.php';
?>

<!-- About Hero Section -->
<section class="about-hero-section">
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">Our Divine Journey</h1>
            <p class="hero-subtitle">Bringing spirituality and tradition into every home since 2020</p>
            <div class="hero-buttons">
                <a href="#our-story" class="btn btn-outline btn-large">📖 Our Story</a>
                <a href="#contact" class="btn btn-primary btn-large">🤝 Get in Touch</a>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-image-wrapper">
                <img src="<?php echo SITE_URL; ?>assets/images/hero-image.svg" alt="Divyaghar Spiritual Store">
                <div class="hero-badge">Since 2020</div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="story-section" id="our-story">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Story</h2>
            <p class="section-subtitle">From a vision to a spiritual destination</p>
        </div>
        <div class="story-content">
            <div class="story-text">
                <p>Founded in 2020, Divyaghar emerged from a simple yet profound vision: to make authentic spiritual items and traditional home décor accessible to every household seeking peace, prosperity, and divine connection.</p>
                <p>What began as a small collection of handpicked pooja essentials has grown into a comprehensive spiritual marketplace, serving thousands of families across India. Our journey has been guided by one principle – to bridge the gap between ancient traditions and modern living.</p>
                <p>Today, Divyaghar stands as a testament to the enduring power of faith and the beauty of traditional craftsmanship. We work directly with over 100 skilled artisans, ensuring that every product carries not just quality, but also the blessings and positive energy it was created with.</p>
            </div>
            <div class="story-visual">
                <div class="achievement-card">
                    <div class="achievement-icon">🏆</div>
                    <div class="achievement-number">50,000+</div>
                    <div class="achievement-label">Happy Families</div>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon">🙏</div>
                    <div class="achievement-number">500+</div>
                    <div class="achievement-label">Spiritual Products</div>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon">🤝</div>
                    <div class="achievement-number">100+</div>
                    <div class="achievement-label">Artisan Partners</div>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon">⭐</div>
                    <div class="achievement-number">4.8★</div>
                    <div class="achievement-label">Customer Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="mission-vision-section">
    <div class="container">
        <div class="mission-vision-grid">
            <div class="mission-card">
                <div class="card-icon">🎯</div>
                <h3>Our Mission</h3>
                <p>To preserve and promote India's rich spiritual heritage by providing authentic, high-quality pooja essentials and spiritual items that bring peace, prosperity, and divine connection to every home.</p>
                <ul class="mission-points">
                    <li>Authentic spiritual products</li>
                    <li>Support traditional artisans</li>
                    <li>Promote spiritual well-being</li>
                    <li>Exceptional customer service</li>
                </ul>
            </div>
            <div class="vision-card">
                <div class="card-icon">🌟</div>
                <h3>Our Vision</h3>
                <p>To become India's most trusted spiritual marketplace, where tradition meets convenience, and every family can access authentic spiritual items that enhance their divine connection.</p>
                <ul class="vision-points">
                    <li>Nationwide presence</li>
                    <li>Digital spiritual community</li>
                    <li>Premium quality standards</li>
                    <li>Sustainable practices</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Core Values Section -->
<section class="values-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Core Values</h2>
            <p class="section-subtitle">The principles that guide everything we do</p>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🙏</div>
                <h3>Authenticity</h3>
                <p>Every product is carefully selected for its authenticity and traditional significance, ensuring genuine spiritual value for our customers.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">💎</div>
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

<!-- How We Work Section -->
<section class="process-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">How We Work</h2>
            <p class="section-subtitle">From selection to delivery, our commitment to excellence</p>
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

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Meet Our Team</h2>
            <p class="section-subtitle">The passionate people behind Divyaghar</p>
        </div>
        <div class="team-grid">
            <div class="team-member">
                <div class="member-image">
                    <img src="https://via.placeholder.com/300x300/1a1a1a/FFD700?text=Rajesh" alt="Rajesh Sharma">
                    <div class="member-badge">Founder</div>
                </div>
                <div class="member-info">
                    <h3>Rajesh Sharma</h3>
                    <p class="member-title">Founder & CEO</p>
                    <p class="member-bio">With over 15 years in spiritual retail, Rajesh envisioned Divyaghar to bridge tradition with modern convenience.</p>
                    <div class="member-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="team-member">
                <div class="member-image">
                    <img src="https://via.placeholder.com/300x300/1a1a1a/FFD700?text=Priya" alt="Priya Nair">
                    <div class="member-badge">Operations</div>
                </div>
                <div class="member-info">
                    <h3>Priya Nair</h3>
                    <p class="member-title">Operations Manager</p>
                    <p class="member-bio">Priya ensures every order is handled with care and reaches customers with the divine blessings it carries.</p>
                    <div class="member-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="team-member">
                <div class="member-image">
                    <img src="https://via.placeholder.com/300x300/1a1a1a/FFD700?text=Amit" alt="Amit Patel">
                    <div class="member-badge">Curation</div>
                </div>
                <div class="member-info">
                    <h3>Amit Patel</h3>
                    <p class="member-title">Product Curator</p>
                    <p class="member-bio">Amit travels across India to discover unique spiritual items and connect with traditional artisans.</p>
                    <div class="member-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Customer Testimonials -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-subtitle">Real experiences from our spiritual community</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>"Divyaghar has transformed my home into a spiritual sanctuary. The quality of their brass idols is exceptional, and the packaging was so thoughtful."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">AR</div>
                    <div class="author-info">
                        <div class="author-name">Anjali Reddy</div>
                        <div class="author-role">Bangalore</div>
                    </div>
                </div>
                <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>"I've been buying from Divyaghar for two years now. Their pooja thalis and incense sticks are authentic and reasonably priced. Highly recommended!"</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">RK</div>
                    <div class="author-info">
                        <div class="author-name">Ramesh Kumar</div>
                        <div class="author-role">Delhi</div>
                    </div>
                </div>
                <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>"The customer service is outstanding. They helped me choose the perfect Ganesh idol for my new home. The item arrived beautifully packaged and on time."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">SP</div>
                    <div class="author-info">
                        <div class="author-name">Sneha Patel</div>
                        <div class="author-role">Mumbai</div>
                    </div>
                </div>
                <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" id="contact">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Join Our Spiritual Community</h2>
            <p class="cta-subtitle">Subscribe to receive updates on new arrivals, spiritual insights, and exclusive offers</p>
            <form class="cta-form">
                <input type="email" class="cta-input" placeholder="Enter your email address" required>
                <button type="submit" class="btn btn-primary btn-large">Subscribe Now</button>
            </form>
            <div class="cta-actions">
                <a href="products.php" class="btn btn-outline btn-large">🛍️ Explore Collection</a>
                <a href="contact.php" class="btn btn-primary btn-large">📞 Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
