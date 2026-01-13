<?php
/**
 * AJAX Handler - Add to Cart
 * Divyaghar E-commerce Website
 */

require_once '../config/database.php';
require_once '../includes/cart_functions.php';

header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get and validate input
$product_id = (int)($_POST['product_id'] ?? 0);
$quantity = (int)($_POST['quantity'] ?? 1);

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product']);
    exit;
}

if ($quantity <= 0) {
    $quantity = 1;
}

// Add to cart
$result = addToCart($product_id, $quantity);

// Get updated cart count
$cart_items = getCartItems();
$cart_count = 0;
foreach ($cart_items as $item) {
    $cart_count += $item['quantity'];
}

// Add cart count to response
$result['cart_count'] = $cart_count;

echo json_encode($result);
?>
