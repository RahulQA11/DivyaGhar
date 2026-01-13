<?php
/**
 * Enhanced About Page - Modern Design & Content
 * Divyaghar E-commerce Website
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

// Set page meta
$page_title = 'About Us - Divyaghar';
$meta_description = 'Learn about Divyaghar - Your trusted destination for high-quality pooja essentials, home décor, god idols, and spiritual gifts since 2020. Discover our story, mission, and commitment to authenticity.';
$meta_keywords = 'about divyaghar, spiritual store, pooja essentials, home decor, about us, our story, our mission, our values';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS with Spiritual Theme -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/style.css?v=<?php echo time(); ?>">
    <style>
        /* About Page Specific Styles */
        body {
            font-family: 'Playfair Display', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            line-height: 1.6;
        }
        
        .about-hero {
            position: relative;
            min-height: 400px;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(212, 175, 55, 0.9));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 60px 20px;
            border-radius: 15px;
            margin-bottom: 40px;
        }
        
        .about-hero-content {
            max-width: 800px;
            z-index: 2;
        }
        
        .about-hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .about-hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .about-hero-image {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.3);
        }
        
        .section {
            padding: 60px 0;
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .mission-section {
            background: rgba(255,255,255,0.05);
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 40px;
        }
        
        .mission-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            align-items: start;
        }
        
        .mission-text {
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .mission-visual {
            background: rgba(212, 175, 55, 0.1);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .values-section {
            background: rgba(255,255,255,0.05);
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 40px;
        }
        
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .value-card {
            background: rgba(255,255,255,0.1);
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid #d4ed31;
        }
        
        .value-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #d4ed31;
        }
        
        .value-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .value-label {
            font-size: 0.9rem;
            color: #666;
        }
        
        .team-section {
            background: rgba(255,255,255,0.05);
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 40px;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .team-member {
            background: rgba(255,255,255,0.1);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid #d4ed31;
        }
        
        .team-member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        
        .team-member h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .team-member p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
        }
        
        .process-section {
            background: rgba(255,255,255,0.05);
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 40px;
        }
        
        .process-timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .process-timeline::before {
            content: '';
            position: absolute;
            left: -15px;
            top: 0;
            width: 2px;
            height: 100%;
            background: #d4ed31;
        }
        
        .process-step {
            position: relative;
            padding: 20px 0 20px 20px 20px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            margin-bottom: 15px;
        }
        
        .process-step::before {
            content: '✨';
            position: absolute;
            left: -15px;
            top: 0;
            width: 20px;
            height: 20px;
            background: #d4ed31;
            color: white;
            font-size: 12px;
            text-align: center;
            line-height: 20px;
        }
        
        .process-step h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .testimonials-section {
            background: rgba(255,255,255,0.05);
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 40px;
        }
        
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .testimonial-card {
            background: rgba(255,255,255,0.1);
            padding: 30px;
            border-radius: 10px;
            border-left: 4px solid #d4ed31;
        }
        
        .testimonial-content {
            font-style: italic;
            font-size: 1rem;
            color: #666;
            margin-bottom: 15px;
        }
        
        .testimonial-author {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .rating {
            color: #ffc107;
            margin-bottom: 10px;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 40px;
        }
        
        .cta-content {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .cta-title {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #d4ed31;
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            color: #d4ed31;
            border: 2px solid #d4ed31;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        @media (max-width: 768px) {
            .about-hero-content {
                grid-template-columns: 1fr;
            }
            
            .about-hero-image {
                position: relative;
                right: 20px;
                top: 30%;
            }
        }
        
        @media (max-width: 480px) {
            .values-grid {
                grid-template-columns: 1fr;
            }
            
            .team-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
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
        <div class="about-hero-content">
            <h1>Our Story</h1>
            <p class="hero-subtitle">Bringing divinity home with authentic spiritual items</p>
            <div class="hero-description">
                Founded in 2020, Divyaghar emerged from a simple yet profound vision: to make authentic spiritual items and traditional home décor accessible to every household seeking peace, prosperity, and divine connection.
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
            </div>
            <div class="mission-content">
                <div class="mission-text">
                    Guided by tradition, dedicated to quality, we are committed to preserving the rich heritage of Indian spiritual traditions while making them relevant to modern homes. Our mission is to:
                </div>
                <ul class="mission-list">
                    <li>Provide authentic, high-quality spiritual items sourced from skilled artisans</li>
                    <li>Promote spiritual well-being and positive energy in every home</li>
                    <li>Make traditional pooja essentials accessible to all generations</li>
                    <li>Support local artisans and preserve traditional craftsmanship</li>
                    <li>Create a seamless online shopping experience for spiritual products</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Values</h2>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">🙏</div>
                    <div class="value-title">Authenticity</div>
                    <div class="value-label">Every product is carefully selected for its authenticity and traditional significance, ensuring genuine spiritual value for our customers.</div>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">✨</div>
                    <div class="value-title">Quality</div>
                    <div class="value-label">We never compromise on quality. Each item undergoes strict quality checks to ensure it meets our high standards of craftsmanship and durability.</div>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">🤝</div>
                    <div class="value-title">Trust</div>
                    <div class="value-label">Built on transparency and integrity, we strive to earn and maintain the trust of every customer through honest business practices.</div>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">🌱</div>
                    <div class="value-title">Sustainability</div>
                    <div class="value-label">We support eco-friendly practices and work with artisans who use sustainable materials, respecting both tradition and environment.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="section-header">
                <h2>Meet Our Team</h2>
            </div>
            <div class="team-grid">
                <div class="team-member">
                    <div class="team-member-image">
                        <img src="<?php echo SITE_URL; ?>assets/images/team/founder.jpg" alt="Founder">
                    </div>
                    <div class="team-member-info">
                        <h3>Rajesh Sharma</h3>
                        <p class="member-title">Founder & CEO</p>
                        <p class="member-bio">With over 15 years in spiritual retail, Rajesh envisioned Divyaghar to bridge tradition with modern convenience. His passion for authentic items and deep understanding of spiritual needs drives our commitment to quality.</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="team-member-image">
                        <img src="<?php echo SITE_URL; ?>assets/images/team/manager.jpg" alt="Operations Manager">
                    </div>
                    <div class="team-member-info">
                        <h3>Priya Nair</h3>
                        <p class="member-title">Operations Manager</p>
                        <p class="member-bio">Priya ensures every order is handled with care and reaches customers with the divine blessings it carries.</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="team-member-image">
                        <img src="<?php echo SITE_URL; ?>assets/images/team/designer.jpg" alt="Product Curator">
                    </div>
                    <div class="team-member-info">
                        <h3>Amit Patel</h3>
                        <p class="member-title">Product Curator</p>
                        <p class="member-bio">Amit travels across India to discover unique spiritual items and connect with traditional artisans, bringing their exceptional craftsmanship to our customers.</p>
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
            </div>
            <div class="process-timeline">
                <div class="process-step">
                    <div class="process-step::before">✨</div>
                    <h3>Artisan Selection</h3>
                    <p>We partner with skilled artisans who have inherited traditional craftsmanship through generations</p>
                </div>
                
                <div class="process-step">
                    <div class="process-step::before">✨</div>
                    <h3>Quality Assurance</h3>
                    <p>Each product undergoes rigorous quality checks to ensure it meets our high standards of authenticity and excellence.</p>
                </div>
                
                <div class="process-step">
                    <div class="process-step::before">✨</div>
                    <h3>Spiritual Blessing</h3>
                    <p>Many of our items receive traditional blessings before being made available to our customers.</p>
                </div>
                
                <div class="process-step">
                    <div class="process-step::before">✨</div>
                    <h3>Secure Packaging</h3>
                    <p>We use eco-friendly, secure packaging to ensure your spiritual items reach you safely and beautifully.</p>
                </div>
                
                <div class="process-step">
                    <div class="process-step::before">✨</div>
                    <h3>Timely Delivery</h3>
                    <p>Our delivery partners ensure your order reaches you with care and respect for the sacred nature of the items.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2>What Our Customers Say</h2>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="testimonial-author">
                            <h4>Anjali Reddy</h4>
                            <span>Bangalore</span>
                        </div>
                        <div class="rating">★★★★★</div>
                        <div class="testimonial-text">
                            "Divyaghar has transformed my home into a spiritual sanctuary. The quality of their brass idols is exceptional, and the packaging was so thoughtful. I've been buying from Divyaghar for two years now."
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="testimonial-author">
                            <h4>Ramesh Kumar</h4>
                            <span>Delhi</span>
                        </div>
                        <div class="rating">★★★★★</div>
                        <div class="testimonial-text">
                            "The customer service is outstanding. They helped me choose the perfect Ganesh idol for my home temple. The entire experience was seamless and the product quality is exceptional."
                        </div>
                    </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="testimonial-author">
                            <h4>Sneha Patel</h4>
                            <span>Mumbai</span>
                        </div>
                        <div class="rating">★★★★★</div>
                        <div class="testimonial-text">
                            "I've been buying from Divyaghar for three years. Their spiritual items have brought positive energy into my home. The craftsmanship is beautiful and the customer service is exceptional."
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Impact</h2>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">🙏</div>
                    <div class="value-title">Happy Customers</div>
                    <div class="value-label">50,000+</div>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">🛍️</div>
                    <div class="value-title">Spiritual Products</div>
                    <div class="value-label">100+</div>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">🎨</div>
                    <div class="value-title">Artisan Partners</div>
                    <div class="value-label">500+</div>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">⭐</div>
                    <div class="value-title">Customer Rating</div>
                    <div class="value-label">4.8★</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Join Our Spiritual Community</h2>
                <p>Subscribe to receive updates on new arrivals, spiritual insights, and exclusive offers</p>
                <div class="cta-actions">
                    <a href="products.php" class="btn btn-primary btn-large">Explore Our Collection</a>
                    <a href="contact.php" class="btn btn-outline btn-large">Get in Touch</a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
