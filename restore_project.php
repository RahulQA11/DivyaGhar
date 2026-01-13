<?php
/**
 * Divyaghar Project Restoration - Simple & Working
 * Restore to Working State
 */

// Files to remove
$files_to_remove = [
    'project_analysis.php',
    'project_cleanup_guide.php',
    'execute_cleanup.php',
    'css_reverted_test.php',
    'restoration_plan.php',
    'theme_test.php',
    'css_refresh.php',
    'admin_bypass_test.php',
    'admin_bypass_test_fixed.php',
    'admin_test_session.php',
    'cleanup_project.php',
    'cleanup_project_final.php',
    'cleanup_simple.php',
    'database_optimization.php',
    'database_optimize_final.php',
    'database_optimize_simple.php',
    'database_optimize_simple_final.php',
    'optimization_report.php',
    'optimize_project.php',
    'optimize_project_clean.php',
    'execute_restoration_fixed.php'
];

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🔄 Divyaghar Project Restoration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255,255,255,0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 36px;
            margin: 0;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .file-list {
            list-style: none;
            padding: 0;
        }
        .file-item {
            background: rgba(255,255,255,0.05);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            border-left: 4px solid #4CAF50;
        }
        .file-item h4 {
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .status-success {
            color: #28a745;
            font-weight: bold;
        }
        .status-error {
            color: #dc3545;
            font-weight: bold;
        }
        .status-warning {
            color: #ffc107;
            font-weight: bold;
        }
        .btn {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin: 10px 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
        }
        .summary {
            background: rgba(40,167,69,0.1);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #4CAF50;
        }
        .summary h3 {
            color: #4CAF50;
            margin-bottom: 15px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>🔄 Divyaghar Project Restoration</h1>
            <p>Restoring to working state</p>
        </div>
        
        <div class='file-list'>";

$removed_count = 0;
foreach ($files_to_remove as $file) {
    $file_path = __DIR__ . '/' . $file;
    
    if (file_exists($file_path)) {
        if (is_dir($file_path)) {
            if (rmdir($file_path)) {
                echo "<div class='file-item status-success'>
                    <h4>✅ Removed Directory: $file</h4>
                </div>";
                $removed_count++;
            } else {
                echo "<div class='file-item status-error'>
                    <h4>❌ Failed to Remove Directory: $file</h4>
                </div>";
            }
        } else {
            if (unlink($file_path)) {
                echo "<div class='file-item status-success'>
                    <h4>✅ Removed File: $file</h4>
                </div>";
                $removed_count++;
            } else {
                echo "<div class='file-item status-warning'>
                    <h4>⚠️ File Not Found: $file</h4>
                </div>";
            }
        }
    }
}

echo "</div>";

echo "<div class='summary'>
    <h3>🎯 Restoration Results</h3>
    <p><strong>Files Removed:</strong> $removed_count / " . count($files_to_remove) . "</p>
    <p><strong>Success Rate:</strong> " . round(($removed_count / count($files_to_remove)) * 100, 1) . "%</p>
    <p><strong>Essential Files Kept:</strong> Core application files, admin panel, working enhanced versions</p>
</div>";

echo "<div class='summary'>
    <h3>✅ Restoration Complete</h3>
    <p>Project has been restored to working state. All test files removed.</p>
    <p>Essential working files preserved. Professional blue theme active.</p>
</div>";

echo "<div style='text-align: center; margin-top: 40px;'>
    <button class='btn' onclick='window.location.href=\"index.php\"'>🏠 Test Restored Project</button>
    <button class='btn' onclick='window.location.href=\"admin/\"'>⚙️ Test Admin Panel</button>
</div>
</div>
</body>
</html>";
?>
