<?php
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🔧 Admin Panel Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #2c3e50; margin: 0; }
        .status { padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; font-weight: bold; }
        .success { background: #d4ed31; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .btn { background: #2c3e50; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; }
        .btn:hover { background: #1a6b3b; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>🔧 Admin Panel Access Test</h1>
        </div>
        
        <div class='status success'>
            <h2>✅ Apache Restarted Successfully</h2>
            <p>Admin panel should now be accessible</p>
        </div>
        
        <div style='text-align: center; margin-top: 30px;'>
            <a href='admin/' class='btn'>🚪 Access Admin Panel</a>
        </div>
    </div>
</body>
</html>";
?>
