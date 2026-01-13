<?php
/**
 * Cart Functions
 * Divyaghar E-commerce Website
 */

/**
 * Add product to cart
 */
function addToCart($product_id, $quantity = 1) {
    global $db;
    
    // Get product details
    $product = $db->fetch("SELECT id, name, price, discount_price, stock_quantity FROM products WHERE id = ? AND status = 'active'", [$product_id]);
    
    if (!$product) {
        return ['success' => false, 'message' => 'Product not found'];
    }
    
    if ($product['stock_quantity'] < $quantity) {
        return ['success' => false, 'message' => 'Insufficient stock'];
    }
    
    // Initialize cart if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Check if product already in cart
    if (isset($_SESSION['cart'][$product_id])) {
        $new_quantity = $_SESSION['cart'][$product_id]['quantity'] + $quantity;
        if ($product['stock_quantity'] < $new_quantity) {
            return ['success' => false, 'message' => 'Insufficient stock'];
        }
        $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['discount_price'] ?: $product['price'],
            'quantity' => $quantity
        ];
    }
    
    return ['success' => true, 'message' => 'Product added to cart'];
}

/**
 * Update cart quantity
 */
function updateQuantity($product_id, $quantity) {
    global $db;
    
    // Get current cart item
    $current_item = $_SESSION['cart'][$product_id] ?? null;
    if (!$current_item) {
        return ['success' => false, 'message' => 'Product not found in cart'];
    }
    
    // Check stock
    $product = $db->fetch("SELECT stock_quantity FROM products WHERE id = ?", [$product_id]);
    if (!$product) {
        return ['success' => false, 'message' => 'Product not found'];
    }
    
    if ($product['stock_quantity'] < $quantity) {
        return ['success' => false, 'message' => 'Insufficient stock available'];
    }
    
    // Update session
    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    
    return ['success' => true, 'message' => 'Cart updated successfully'];
}

/**
 * Handle AJAX requests
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'update':
            $product_id = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            $result = updateQuantity($product_id, $quantity);
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
            
        case 'remove':
            $product_id = (int)$_POST['product_id'];
            $result = removeFromCart($product_id);
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
            
        case 'clear':
            $result = clearCart();
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
            
        case 'totals':
            $totals = calculateCartTotals();
            header('Content-Type: application/json');
            echo json_encode($totals);
            exit;
    }
}

/**
 * Remove from cart
 */
function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        return ['success' => true, 'message' => 'Product removed from cart'];
    }
    return ['success' => false, 'message' => 'Product not in cart'];
}

/**
 * Clear cart
 */
function clearCart() {
    $_SESSION['cart'] = [];
    return ['success' => true, 'message' => 'Cart cleared'];
}

/**
 * Get cart items with product details
 */
function getCartItems() {
    global $db;
    
    if (empty($_SESSION['cart'])) {
        return [];
    }
    
    $cart_items = [];
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $product_details = $db->fetch("SELECT p.*, c.name as category_name, c.slug as category_slug,
                                       (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 'yes' LIMIT 1) as primary_image
                                       FROM products p 
                                       LEFT JOIN categories c ON p.category_id = c.id 
                                       WHERE p.id = ?", [$product_id]);
        
        if ($product_details) {
            $cart_items[] = array_merge($item, [
                'slug' => $product_details['slug'],
                'category_name' => $product_details['category_name'],
                'category_slug' => $product_details['category_slug'],
                'primary_image' => $product_details['primary_image'],
                'stock_quantity' => $product_details['stock_quantity'],
                'price' => $item['price'],
                'discount_price' => $item['discount_price'] ?? null
            ]);
        }
    }
    
    return $cart_items;
}

/**
 * Calculate cart totals
 */
function calculateCartTotals() {
    $subtotal = 0;
    $total_items = 0;
    
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $total_items += $item['quantity'];
        }
    }
    
    $tax_amount = $subtotal * 0.18; // 18% GST
    $shipping_amount = $subtotal >= 999 ? 0 : 50; // Free shipping above 999
    $total_amount = $subtotal + $tax_amount + $shipping_amount;
    
    return [
        'subtotal' => $subtotal,
        'tax_amount' => $tax_amount,
        'shipping_amount' => $shipping_amount,
        'total_amount' => $total_amount,
        'total_items' => $total_items
    ];
}
?>
