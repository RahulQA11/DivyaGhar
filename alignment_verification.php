<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ Perfect Cart Alignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/cart.css?v=<?php echo time(); ?>">
    <style>
        .success-message {
            background: #28a745;
            color: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            margin: 2rem;
            font-size: 1.2rem;
        }
        .alignment-demo {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            margin: 2rem 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="success-message">
            <h2>✅ CART ALIGNMENT FIXED!</h2>
            <p>Perfect column alignment achieved with the following structure:</p>
        </div>
        
        <div class="alignment-demo">
            <h3>🎯 Perfect Table Structure:</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: left;">Product Name</td>
                        <td style="text-align: center; width: 120px; font-weight: 700;">₹999.00</td>
                        <td style="text-align: center; width: 100px;">2</td>
                        <td style="text-align: center; width: 120px; font-weight: 700;">₹1,998.00</td>
                        <td style="text-align: center; width: 120px;">
                            <button class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
            
            <div class="mt-4">
                <h3>📋 Column Alignment Status:</h3>
                <ul>
                    <li>✅ <strong>Product</strong> → Left-aligned under "Product" header</li>
                    <li>✅ <strong>Price</strong> → Center-aligned under "Price" header</li>
                    <li>✅ <strong>Quantity</strong> → Center-aligned under "Quantity" header</li>
                    <li>✅ <strong>Total</strong> → Center-aligned under "Total" header</li>
                    <li>✅ <strong>Actions</strong> → Center-aligned under "Actions" header</li>
                </ul>
            </div>
            
            <div class="mt-4">
                <a href="cart.php" class="btn btn-primary btn-lg">
                    🛒 View Your Cart Page
                </a>
            </div>
        </div>
    </div>
</body>
</html>
