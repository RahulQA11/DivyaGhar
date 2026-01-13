<?php
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'admin';
$_SESSION['username'] = 'admin';

echo "<h1>Admin Session Created</h1>";
echo "<p>Access: <a href='admin/dashboard.php'>Admin Dashboard</a></p>";
?>
