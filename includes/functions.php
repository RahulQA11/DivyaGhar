<?php
/**
 * Helper Functions
 * Divyaghar E-commerce Website
 */

/**
 * Clean input data to prevent XSS
 */
function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Generate URL-friendly slug
 */
function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

/**
 * Format price with currency
 */
function formatPrice($price) {
    return '₹' . number_format($price, 2);
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if user is admin
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Redirect to URL
 */
function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit();
}

/**
 * Display success message
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

/**
 * Get and clear flash message
 */
function getFlashMessage($type) {
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}

/**
 * Hash password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => HASH_COST]);
}

/**
 * Verify password
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Generate random string
 */
function generateRandomString($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Validate email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Upload image
 */
function uploadImage($file, $destination = 'products') {
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return ['success' => false, 'message' => 'No file uploaded'];
    }
    
    // Check file size
    if ($file['size'] > MAX_IMAGE_SIZE) {
        return ['success' => false, 'message' => 'File size too large'];
    }
    
    // Check file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime_type, ALLOWED_IMAGE_TYPES)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = generateRandomString(16) . '.' . $extension;
    $upload_dir = UPLOAD_PATH . $destination . '/';
    
    // Create directory if not exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $upload_dir . $filename)) {
        return [
            'success' => true, 
            'filename' => $filename,
            'path' => $destination . '/' . $filename
        ];
    }
    
    return ['success' => false, 'message' => 'Upload failed'];
}

/**
 * Delete image
 */
function deleteImage($path) {
    $full_path = UPLOAD_PATH . $path;
    if (file_exists($full_path)) {
        return unlink($full_path);
    }
    return false;
}

/**
 * Get cart count
 */
function getCartCount() {
    if (!isset($_SESSION['cart'])) {
        return 0;
    }
    
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
    return $count;
}

/**
 * Get cart total
 */
function getCartTotal() {
    if (!isset($_SESSION['cart'])) {
        return 0;
    }
    
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

/**
 * Generate order number
 */
function generateOrderNumber() {
    return 'DG' . date('Y') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

/**
 * Truncate text
 */
function truncateText($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

function getProductImage($image_path) {
    if ($image_path && file_exists(ROOT_PATH . '/uploads/' . $image_path)) {
        return SITE_URL . 'uploads/' . $image_path;
    }
    return SITE_URL . 'assets/images/placeholder-product.svg';
}

function getCategoryImage($image_path = null) {
    if ($image_path && file_exists(ROOT_PATH . '/uploads/' . $image_path)) {
        return SITE_URL . 'uploads/' . $image_path;
    }
    return SITE_URL . 'assets/images/placeholder-category.svg';
}

/**
 * Get pagination HTML
 */
function getPagination($current_page, $total_pages, $url_pattern) {
    if ($total_pages <= 1) {
        return '';
    }
    
    $html = '<div class="pagination">';
    
    // Previous button
    if ($current_page > 1) {
        $html .= '<a href="' . sprintf($url_pattern, $current_page - 1) . '" class="prev">&laquo; Previous</a>';
    }
    
    // Page numbers
    $start = max(1, $current_page - 2);
    $end = min($total_pages, $current_page + 2);
    
    if ($start > 1) {
        $html .= '<a href="' . sprintf($url_pattern, 1) . '">1</a>';
        if ($start > 2) {
            $html .= '<span class="dots">...</span>';
        }
    }
    
    for ($i = $start; $i <= $end; $i++) {
        $class = ($i == $current_page) ? 'active' : '';
        $html .= '<a href="' . sprintf($url_pattern, $i) . '" class="' . $class . '">' . $i . '</a>';
    }
    
    if ($end < $total_pages) {
        if ($end < $total_pages - 1) {
            $html .= '<span class="dots">...</span>';
        }
        $html .= '<a href="' . sprintf($url_pattern, $total_pages) . '">' . $total_pages . '</a>';
    }
    
    // Next button
    if ($current_page < $total_pages) {
        $html .= '<a href="' . sprintf($url_pattern, $current_page + 1) . '" class="next">Next &raquo;</a>';
    }
    
    $html .= '</div>';
    return $html;
}

/**
 * Send email (basic implementation)
 */
function sendEmail($to, $subject, $message, $headers = '') {
    $default_headers = "From: " . SITE_NAME . " <" . SITE_EMAIL . ">\r\n";
    $default_headers .= "MIME-Version: 1.0\r\n";
    $default_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    $headers = $headers ? $headers : $default_headers;
    
    return mail($to, $subject, $message, $headers);
}

/**
 * Debug function
 */
function debug($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
?>
