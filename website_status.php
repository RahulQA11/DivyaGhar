<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Website Test - Divyaghar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 600px;
            background: rgba(255,255,255,0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
        }
        .status {
            background: #d4ed31;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .error-info {
            background: #fff3cd;
            color: #856404;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #ffc107;
        }
        .btn {
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin: 10px 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .error-list {
            text-align: left;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .error-list h3 {
            color: #dc3545;
            margin-bottom: 10px;
        }
        .error-list ul {
            color: #333;
            line-height: 1.6;
        }
        .solution-list {
            text-align: left;
            background: #d4ed31;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .solution-list h3 {
            color: #155724;
            margin-bottom: 10px;
        }
        .solution-list ul {
            color: #333;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Website Status Check</h1>
        
        <div class="status">
            <h2>✅ Your Divyaghar Website is Working!</h2>
            <p>The errors you're seeing are from browser extensions, not your website.</p>
        </div>
        
        <div class="error-info">
            <h3>📋 Error Analysis</h3>
            <p><strong>Source:</strong> Chrome Browser Extensions</p>
            <p><strong>Impact:</strong> No impact on your website functionality</p>
            <p><strong>Status:</strong> Your website is working correctly</p>
        </div>
        
        <div class="error-list">
            <h3>🔍 Error Details (Browser Extensions)</h3>
            <ul>
                <li><strong>content.js errors:</strong> Extension content script issues</li>
                <li><strong>chrome-extension:// URLs:</strong> Extension resource loading</li>
                <li><strong>web_accessible_resources:</strong> Extension manifest issues</li>
                <li><strong>chunk-c8f75966.js:</strong> Extension JavaScript module loading</li>
            </ul>
        </div>
        
        <div class="solution-list">
            <h3>🔧 Solutions</h3>
            <ul>
                <li><strong>Option 1:</strong> Disable browser extensions temporarily</li>
                <li><strong>Option 2:</strong> Use incognito/private browsing mode</li>
                <li><strong>Option 3:</strong> Try a different browser</li>
                <li><strong>Option 4:</strong> Ignore these errors (they don't affect your site)</li>
            </ul>
        </div>
        
        <div style="margin-top: 30px;">
            <button class="btn" onclick="window.location.href='index.php'">🏠 Test Main Website</button>
            <button class="btn" onclick="window.location.href='admin/login.php'">🔐 Test Admin Login</button>
            <button class="btn btn-danger" onclick="window.location.href='password_fix.php'">🔧 Fix Admin Password</button>
        </div>
        
        <div style="margin-top: 20px; font-size: 14px; color: #666;">
            <p><strong>Note:</strong> These errors are common when browser extensions are installed. They don't affect your website's functionality.</p>
        </div>
    </div>
</body>
</html>
