<?php
/**
 404 Error Page
 Divyaghar E-commerce Website
 */

$page_title = 'Page Not Found - Divyaghar';
$meta_description = 'The page you are looking for could not be found. Browse our collection of spiritual items and home décor.';
$meta_keywords = '404, page not found, divyaghar, spiritual items';

include 'includes/header.php';
?>

<section class="error-section">
    <div class="container">
        <div class="error-content">
            <div class="error-number">404</div>
            <h1>Page Not Found</h1>
            <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            
            <div class="error-actions">
                <a href="index.php" class="btn btn-primary">Go to Homepage</a>
                <a href="products.php" class="btn btn-outline">Browse Products</a>
            </div>
            
            <div class="search-suggestions">
                <h3>Looking for something specific?</h3>
                <p>Try searching for our popular products:</p>
                <div class="popular-links">
                    <a href="search.php?q=ganesh idol">Ganesh Idols</a>
                    <a href="search.php?q=brass diya">Brass Diyas</a>
                    <a href="search.php?q=pooja thali">Pooja Thalis</a>
                    <a href="search.php?q=incense sticks">Incense Sticks</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
