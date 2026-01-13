<?php
/**
 README - Divyaghar E-commerce Website
 Complete PHP E-commerce Solution
 */

# Divyaghar E-commerce Website

A complete, production-ready e-commerce website for selling spiritual items, pooja essentials, home décor, god idols, and spiritual gifts.

## 📋 Features

### Frontend
- **Responsive Design**: Mobile-first, works on all devices
- **SEO Optimized**: Clean URLs, meta tags, semantic HTML
- **Product Catalog**: Categories, product listings, detailed views
- **Shopping Cart**: Add to cart, quantity management, price calculation
- **Checkout Process**: Secure order placement with email confirmations
- **Search & Filters**: Advanced search with category and price filters
- **Contact Forms**: Customer inquiries with email notifications
- **Newsletter Subscription**: Email marketing integration

### Admin Panel
- **Secure Authentication**: Password hashing, session management
- **Dashboard**: Overview statistics and recent activity
- **Category Management**: Full CRUD operations
- **Product Management**: Add/edit products with multiple image uploads
- **Order Management**: View orders, update status, customer details
- **Message Management**: Handle customer inquiries
- **Image Management**: Upload, delete, set primary images

### Security Features
- **SQL Injection Prevention**: Prepared statements
- **XSS Protection**: Input sanitization, output encoding
- **CSRF Protection**: Token-based request validation
- **Rate Limiting**: Prevent brute force attacks
- **File Upload Security**: Type validation, size limits
- **Session Security**: Secure session management
- **Password Security**: Bcrypt hashing

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+ (Core PHP, no framework)
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Styling**: Custom CSS with CSS Grid/Flexbox
- **Fonts**: Google Fonts (Playfair Display, Poppins)
- **Icons**: Emoji-based (lightweight, no external dependencies)

## 📁 Project Structure

```
/divyaghar
├── admin/                  # Admin panel files
│   ├── login.php          # Admin login
│   ├── dashboard.php      # Admin dashboard
│   ├── categories.php     # Category management
│   ├── products.php       # Product management
│   ├── orders.php         # Order management
│   ├── messages.php       # Contact messages
│   ├── auth_check.php     # Authentication middleware
│   └── logout.php         # Admin logout
├── ajax/                   # AJAX handlers
│   ├── add_to_cart.php    # Add to cart functionality
│   ├── get_cart_count.php # Cart count update
│   └── newsletter_subscribe.php # Newsletter signup
├── assets/                 # Static assets
│   ├── css/
│   │   ├── style.css      # Main stylesheet
│   │   └── admin.css      # Admin panel styles
│   ├── js/
│   │   └── script.js      # Main JavaScript
│   └── images/            # Site images
├── includes/               # PHP includes
│   ├── header.php         # Site header
│   ├── footer.php         # Site footer
│   ├── functions.php      # Helper functions
│   ├── cart_functions.php # Cart management
│   ├── csrf.php           # CSRF protection
│   ├── validator.php      # Input validation
│   └── rate_limiter.php   # Rate limiting
├── config/                 # Configuration files
│   ├── database.php       # Database settings
│   └── connection.php     # Database connection
├── uploads/                # User uploads (product images)
├── index.php              # Homepage
├── category.php           # Category page
├── product.php            # Product detail page
├── products.php           # All products page
├── cart.php               # Shopping cart
├── checkout.php           # Checkout process
├── order_confirmation.php # Order confirmation
├── search.php             # Search results
├── about.php              # About page
├── contact.php            # Contact page
├── database.sql           # Database schema
├── .htaccess              # Apache configuration
└── README.md              # This file
```

## 🚀 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite
- GD extension for image processing

### Setup Steps

1. **Database Setup**
   ```bash
   # Create database
   mysql -u root -p
   CREATE DATABASE divyaghar_db;
   
   # Import schema
   mysql -u root -p divyaghar_db < database.sql
   ```

2. **Configuration**
   ```bash
   # Update database credentials
   Edit config/database.php
   Set your DB_HOST, DB_NAME, DB_USER, DB_PASS
   ```

3. **File Permissions**
   ```bash
   # Set write permissions for uploads
   chmod 755 uploads/
   chmod 755 uploads/products/
   ```

4. **Web Server**
   - Place files in web root (htdocs/www)
   - Ensure Apache mod_rewrite is enabled
   - Set AllowOverride All in Apache config

5. **Access Site**
   - Frontend: http://localhost/DivyaGhar/
   - Admin Panel: http://localhost/DivyaGhar/admin/
   - Default Admin: admin / admin123

## 🎨 Design System

### Colors
- **Sandalwood Beige**: #D2B48C
- **Ivory White**: #FFFFF0
- **Maroon**: #800000
- **Antique Gold**: #CFB53B
- **Soft Brown**: #8B7355

### Typography
- **Headings**: Playfair Display (serif)
- **Body**: Poppins (sans-serif)

### Design Principles
- Clean, minimal layout
- Lots of white space
- Soft shadows and rounded corners
- Easy navigation for all ages
- Mobile-first responsive design

## 📊 Database Schema

### Main Tables
- **users**: Admin users
- **categories**: Product categories
- **products**: Product information
- **product_images**: Product image gallery
- **orders**: Customer orders
- **order_items**: Order line items
- **contact_messages**: Customer inquiries
- **cart**: Session-based cart storage

## 🔧 Configuration

### Database Settings
Edit `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'divyaghar_db');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Site Settings
Edit `config/database.php`:
```php
define('SITE_URL', 'http://localhost/DivyaGhar/');
define('SITE_NAME', 'Divyaghar');
define('SITE_EMAIL', 'info@divyaghar.com');
```

## 🚀 Features Usage

### Adding Products
1. Login to admin panel
2. Go to Products → Add Product
3. Fill product details
4. Upload images (first image becomes primary)
5. Set SEO meta tags
6. Save product

### Managing Orders
1. Go to Orders in admin panel
2. View order details
3. Update order status
4. Customer receives email notifications

### Cart System
- Session-based cart (no login required)
- Real-time cart count updates
- Price calculation with tax and shipping
- Stock validation

## 🔒 Security Features

### Input Validation
- All user inputs are sanitized
- Custom validator class for comprehensive validation
- SQL injection prevention with prepared statements

### Authentication
- Secure password hashing (bcrypt)
- Session-based authentication
- CSRF token protection
- Rate limiting for login attempts

### File Upload Security
- File type validation
- Size limits (5MB max)
- Secure file naming
- Upload directory protection

## 📧 Email Configuration

### Current Setup
- Uses PHP mail() function
- Basic HTML email templates
- Order confirmations
- Contact form notifications

### Production Setup
Configure SMTP in `php.ini`:
```ini
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from=info@divyaghar.com
```

## 🌐 SEO Features

### URL Structure
- Clean, SEO-friendly URLs
- Category and product slugs
- Search engine optimized

### Meta Tags
- Dynamic meta titles and descriptions
- Product-specific SEO fields
- Structured data ready

### Performance
- Gzip compression
- Browser caching
- Image optimization
- Minified CSS/JS

## 📱 Responsive Design

### Breakpoints
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

### Features
- Touch-friendly navigation
- Mobile-optimized checkout
- Responsive image galleries
- Adaptive layouts

## 🔄 Maintenance

### Regular Tasks
- Database backups
- Log file monitoring
- Security updates
- Performance optimization

### Monitoring
- Error logging
- Order tracking
- Customer feedback
- Site analytics

## 🤝 Support

### Documentation
- Inline code comments
- Function documentation
- Database schema documentation

### Common Issues
1. **404 Errors**: Check .htaccess configuration
2. **Database Errors**: Verify credentials and permissions
3. **Image Upload**: Check folder permissions
4. **Email Issues**: Configure SMTP settings

## 📄 License

This project is for educational and commercial use. Feel free to modify and distribute as needed.

## 🙏 Acknowledgments

- Spiritual theme inspiration from traditional Indian design
- Modern e-commerce best practices
- Open source PHP community
- Customer feedback and suggestions

---

**Divyaghar** - Bringing divinity home with quality spiritual items and traditional craftsmanship.
"# DivyaGhar" 
