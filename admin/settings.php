<?php
/**
 * Settings Management
 * Divyaghar E-commerce Website
 */

require_once 'auth_check.php';

$action = $_GET['action'] ?? 'general';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'general') {
        $settings = [
            'site_name' => clean($_POST['site_name'] ?? 'Divyaghar'),
            'site_description' => clean($_POST['site_description'] ?? ''),
            'site_email' => clean($_POST['site_email'] ?? ''),
            'site_phone' => clean($_POST['site_phone'] ?? ''),
            'site_address' => clean($_POST['site_address'] ?? ''),
            'currency' => clean($_POST['currency'] ?? 'INR'),
            'tax_rate' => (float)($_POST['tax_rate'] ?? 0),
            'shipping_cost' => (float)($_POST['shipping_cost'] ?? 0),
            'free_shipping_threshold' => (float)($_POST['free_shipping_threshold'] ?? 999)
        ];
        
        foreach ($settings as $key => $value) {
            $db->query("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
                        ON DUPLICATE KEY UPDATE setting_value = ?", [$key, $value, $value]);
        }
        
        setFlashMessage('success', 'General settings updated successfully');
        redirect('admin/settings.php?action=general');
    }
    
    if ($action === 'payment') {
        $settings = [
            'payment_methods' => json_encode($_POST['payment_methods'] ?? []),
            'cod_enabled' => isset($_POST['cod_enabled']) ? '1' : '0',
            'cod_min_amount' => (float)($_POST['cod_min_amount'] ?? 0),
            'paypal_enabled' => isset($_POST['paypal_enabled']) ? '1' : '0',
            'paypal_email' => clean($_POST['paypal_email'] ?? ''),
            'stripe_enabled' => isset($_POST['stripe_enabled']) ? '1' : '0',
            'stripe_public_key' => clean($_POST['stripe_public_key'] ?? ''),
            'stripe_secret_key' => clean($_POST['stripe_secret_key'] ?? '')
        ];
        
        foreach ($settings as $key => $value) {
            $db->query("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
                        ON DUPLICATE KEY UPDATE setting_value = ?", [$key, $value, $value]);
        }
        
        setFlashMessage('success', 'Payment settings updated successfully');
        redirect('admin/settings.php?action=payment');
    }
    
    if ($action === 'email') {
        $settings = [
            'smtp_host' => clean($_POST['smtp_host'] ?? ''),
            'smtp_port' => (int)($_POST['smtp_port'] ?? 587),
            'smtp_username' => clean($_POST['smtp_username'] ?? ''),
            'smtp_password' => clean($_POST['smtp_password'] ?? ''),
            'smtp_encryption' => clean($_POST['smtp_encryption'] ?? 'tls'),
            'email_from_name' => clean($_POST['email_from_name'] ?? 'Divyaghar'),
            'email_from_address' => clean($_POST['email_from_address'] ?? '')
        ];
        
        foreach ($settings as $key => $value) {
            $db->query("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
                        ON DUPLICATE KEY UPDATE setting_value = ?", [$key, $value, $value]);
        }
        
        setFlashMessage('success', 'Email settings updated successfully');
        redirect('admin/settings.php?action=email');
    }
}

// Get current settings
function getSetting($key) {
    global $db;
    $result = $db->fetch("SELECT setting_value FROM settings WHERE setting_key = ?", [$key]);
    return $result ? $result['setting_value'] : null;
}

$general_settings = [
    'site_name' => getSetting('site_name') ?: 'Divyaghar',
    'site_description' => getSetting('site_description') ?: '',
    'site_email' => getSetting('site_email') ?: '',
    'site_phone' => getSetting('site_phone') ?: '',
    'site_address' => getSetting('site_address') ?: '',
    'currency' => getSetting('currency') ?: 'INR',
    'tax_rate' => getSetting('tax_rate') ?: 0,
    'shipping_cost' => getSetting('shipping_cost') ?: 0,
    'free_shipping_threshold' => getSetting('free_shipping_threshold') ?: 999
];

$payment_settings = [
    'payment_methods' => json_decode(getSetting('payment_methods') ?: '["cod", "paypal"]', true),
    'cod_enabled' => getSetting('cod_enabled') ?: '1',
    'cod_min_amount' => getSetting('cod_min_amount') ?: 0,
    'paypal_enabled' => getSetting('paypal_enabled') ?: '0',
    'paypal_email' => getSetting('paypal_email') ?: '',
    'stripe_enabled' => getSetting('stripe_enabled') ?: '0',
    'stripe_public_key' => getSetting('stripe_public_key') ?: '',
    'stripe_secret_key' => getSetting('stripe_secret_key') ?: ''
];

$email_settings = [
    'smtp_host' => getSetting('smtp_host') ?: '',
    'smtp_port' => getSetting('smtp_port') ?: 587,
    'smtp_username' => getSetting('smtp_username') ?: '',
    'smtp_password' => getSetting('smtp_password') ?: '',
    'smtp_encryption' => getSetting('smtp_encryption') ?: 'tls',
    'email_from_name' => getSetting('email_from_name') ?: 'Divyaghar',
    'email_from_address' => getSetting('email_from_address') ?: ''
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Divyaghar Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Divyaghar</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="settings.php" class="active">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="content-header">
                <h1>Settings</h1>
            </header>

            <?php if ($error = getFlashMessage('error')): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success = getFlashMessage('success')): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <!-- Settings Navigation -->
            <div class="settings-nav">
                <a href="?action=general" class="<?php echo $action === 'general' ? 'active' : ''; ?>">General</a>
                <a href="?action=payment" class="<?php echo $action === 'payment' ? 'active' : ''; ?>">Payment</a>
                <a href="?action=email" class="<?php echo $action === 'email' ? 'active' : ''; ?>">Email</a>
            </div>

            <?php if ($action === 'general'): ?>
                <!-- General Settings -->
                <div class="form-container">
                    <h2>General Settings</h2>
                    
                    <form method="POST" class="admin-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="site_name">Site Name</label>
                                <input type="text" id="site_name" name="site_name" 
                                       value="<?php echo htmlspecialchars($general_settings['site_name']); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="site_email">Site Email</label>
                                <input type="email" id="site_email" name="site_email" 
                                       value="<?php echo htmlspecialchars($general_settings['site_email']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="site_description">Site Description</label>
                            <textarea id="site_description" name="site_description" rows="3"><?php echo htmlspecialchars($general_settings['site_description']); ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="site_phone">Site Phone</label>
                                <input type="tel" id="site_phone" name="site_phone" 
                                       value="<?php echo htmlspecialchars($general_settings['site_phone']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select id="currency" name="currency">
                                    <option value="INR" <?php echo $general_settings['currency'] === 'INR' ? 'selected' : ''; ?>>INR (₹)</option>
                                    <option value="USD" <?php echo $general_settings['currency'] === 'USD' ? 'selected' : ''; ?>>USD ($)</option>
                                    <option value="EUR" <?php echo $general_settings['currency'] === 'EUR' ? 'selected' : ''; ?>>EUR (€)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="site_address">Site Address</label>
                            <textarea id="site_address" name="site_address" rows="3"><?php echo htmlspecialchars($general_settings['site_address']); ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="tax_rate">Tax Rate (%)</label>
                                <input type="number" id="tax_rate" name="tax_rate" step="0.01" min="0" 
                                       value="<?php echo $general_settings['tax_rate']; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="shipping_cost">Default Shipping Cost</label>
                                <input type="number" id="shipping_cost" name="shipping_cost" step="0.01" min="0" 
                                       value="<?php echo $general_settings['shipping_cost']; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="free_shipping_threshold">Free Shipping Threshold</label>
                            <input type="number" id="free_shipping_threshold" name="free_shipping_threshold" step="0.01" min="0" 
                                   value="<?php echo $general_settings['free_shipping_threshold']; ?>">
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>

            <?php elseif ($action === 'payment'): ?>
                <!-- Payment Settings -->
                <div class="form-container">
                    <h2>Payment Settings</h2>
                    
                    <form method="POST" class="admin-form">
                        <h3>Cash on Delivery</h3>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="cod_enabled" value="1" 
                                       <?php echo $payment_settings['cod_enabled'] === '1' ? 'checked' : ''; ?>>
                                Enable Cash on Delivery
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label for="cod_min_amount">Minimum Order Amount for COD</label>
                            <input type="number" id="cod_min_amount" name="cod_min_amount" step="0.01" min="0" 
                                   value="<?php echo $payment_settings['cod_min_amount']; ?>">
                        </div>
                        
                        <h3>PayPal</h3>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="paypal_enabled" value="1" 
                                       <?php echo $payment_settings['paypal_enabled'] === '1' ? 'checked' : ''; ?>>
                                Enable PayPal
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label for="paypal_email">PayPal Email</label>
                            <input type="email" id="paypal_email" name="paypal_email" 
                                   value="<?php echo htmlspecialchars($payment_settings['paypal_email']); ?>">
                        </div>
                        
                        <h3>Stripe</h3>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="stripe_enabled" value="1" 
                                       <?php echo $payment_settings['stripe_enabled'] === '1' ? 'checked' : ''; ?>>
                                Enable Stripe
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label for="stripe_public_key">Stripe Public Key</label>
                            <input type="text" id="stripe_public_key" name="stripe_public_key" 
                                   value="<?php echo htmlspecialchars($payment_settings['stripe_public_key']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="stripe_secret_key">Stripe Secret Key</label>
                            <input type="password" id="stripe_secret_key" name="stripe_secret_key" 
                                   value="<?php echo htmlspecialchars($payment_settings['stripe_secret_key']); ?>">
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>

            <?php elseif ($action === 'email'): ?>
                <!-- Email Settings -->
                <div class="form-container">
                    <h2>Email Settings</h2>
                    
                    <form method="POST" class="admin-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="smtp_host">SMTP Host</label>
                                <input type="text" id="smtp_host" name="smtp_host" 
                                       value="<?php echo htmlspecialchars($email_settings['smtp_host']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtp_port">SMTP Port</label>
                                <input type="number" id="smtp_port" name="smtp_port" 
                                       value="<?php echo $email_settings['smtp_port']; ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="smtp_username">SMTP Username</label>
                                <input type="text" id="smtp_username" name="smtp_username" 
                                       value="<?php echo htmlspecialchars($email_settings['smtp_username']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtp_password">SMTP Password</label>
                                <input type="password" id="smtp_password" name="smtp_password" 
                                       value="<?php echo htmlspecialchars($email_settings['smtp_password']); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="smtp_encryption">SMTP Encryption</label>
                            <select id="smtp_encryption" name="smtp_encryption">
                                <option value="none" <?php echo $email_settings['smtp_encryption'] === 'none' ? 'selected' : ''; ?>>None</option>
                                <option value="tls" <?php echo $email_settings['smtp_encryption'] === 'tls' ? 'selected' : ''; ?>>TLS</option>
                                <option value="ssl" <?php echo $email_settings['smtp_encryption'] === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                            </select>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email_from_name">From Name</label>
                                <input type="text" id="email_from_name" name="email_from_name" 
                                       value="<?php echo htmlspecialchars($email_settings['email_from_name']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="email_from_address">From Address</label>
                                <input type="email" id="email_from_address" name="email_from_address" 
                                       value="<?php echo htmlspecialchars($email_settings['email_from_address']); ?>">
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
