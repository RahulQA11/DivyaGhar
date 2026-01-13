<?php
/**
 * AJAX Handler - Get Cart Count
 * Divyaghar E-commerce Website
 */

require_once '../config/database.php';
require_once '../includes/cart_functions.php';

header('Content-Type: application/json');

// Get cart count
$cart_items = getCartItems();
$cart_count = 0;

foreach ($cart_items as $item) {
    $cart_count += $item['quantity'];
}

echo json_encode(['count' => $cart_count]);
?>
