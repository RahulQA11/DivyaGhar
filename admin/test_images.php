<?php
/**
 * Test Multiple Images & URL Upload
 * Divyaghar E-commerce Website
 */

require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Images Test - Divyaghar Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Divyaghar</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="products.php" class="active">Products</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <h1>🖼️ Multiple Images & URL Upload Test</h1>
                <a href="?action=add" class="btn btn-primary">➕ Test Add Product</a>
            </header>

            <div class="card">
                <div class="card-header">
                    <h2>✨ New Features Added:</h2>
                </div>
                <div class="card-content">
                    <h3>🎯 Multiple Image Upload</h3>
                    <ul>
                        <li>✅ Upload multiple images at once</li>
                        <li>✅ First image automatically set as primary</li>
                        <li>✅ Image preview on click</li>
                        <li>✅ Delete individual images</li>
                        <li>✅ Set any image as primary</li>
                    </ul>

                    <h3>🌐 URL Support</h3>
                    <ul>
                        <li>✅ Add external image URLs</li>
                        <li>✅ Dynamic URL input fields</li>
                        <li>✅ Add/remove URL inputs</li>
                        <li>✅ Mixed upload + URL support</li>
                    </ul>

                    <h3>🖼️ Image Management</h3>
                    <ul>
                        <li>✅ Image preview modal</li>
                        <li>✅ Hover effects on images</li>
                        <li>✅ Professional image grid layout</li>
                        <li>✅ Delete and set primary actions</li>
                    </ul>

                    <h3>🎨 Enhanced UI</h3>
                    <ul>
                        <li>✅ Professional modal preview</li>
                        <li>✅ Smooth animations and transitions</li>
                        <li>✅ Responsive image grid</li>
                        <li>✅ Better visual feedback</li>
                    </ul>

                    <div style="margin-top: 2rem; padding: 1rem; background: #e8f5f5; border-radius: 8px;">
                        <h3>🚀 Test Instructions:</h3>
                        <ol>
                            <li>Click "Test Add Product" above</li>
                            <li>Upload multiple images or add URLs</li>
                            <li>Click on any image to see preview</li>
                            <li>Use delete and set primary buttons</li>
                            <li>Test all functionality works as expected</li>
                        </ol>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
