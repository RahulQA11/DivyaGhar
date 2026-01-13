<?php
/**
 * Admin Login Page
 * Divyaghar E-commerce Website
 */

require_once '../config/database.php';

// Check if admin is already logged in
if (isAdmin()) {
    redirect('admin/dashboard.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }
    
    if (empty($errors)) {
        // Check user credentials
        $sql = "SELECT * FROM users WHERE username = ? AND role = 'admin'";
        $user = $db->fetch($sql, [$username]);
        
        if ($user && verifyPassword($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['login_time'] = time();
            
            setFlashMessage('success', 'Welcome back, ' . $user['username'] . '!');
            redirect('admin/dashboard.php');
        } else {
            $errors['login'] = 'Invalid username or password';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Divyaghar</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Divyaghar</h1>
                <p>Admin Panel</p>
            </div>
            
            <?php if ($error = getFlashMessage('error')): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($error = getFlashMessage('success')): ?>
                <div class="alert alert-success"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
                    <?php if (isset($errors['username'])): ?>
                        <span class="error"><?php echo $errors['username']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <?php if (isset($errors['password'])): ?>
                        <span class="error"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <?php if (isset($errors['login'])): ?>
                    <div class="alert alert-error"><?php echo $errors['login']; ?></div>
                <?php endif; ?>
                
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            
            <div class="login-footer">
                <p>Default: admin / admin123</p>
            </div>
        </div>
    </div>
</body>
</html>
