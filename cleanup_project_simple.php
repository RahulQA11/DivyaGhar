<?php
$files_to_remove = [
    'index_backup_final.php',
    'index_mdb5.php', 
    'index_mdb5_old.php',
    'index_original.php',
    'index_minimal.php',
    'index_professional.php',
    'index_professional_final.php',
    'cart_old.php',
    'test_alignment.php',
    'table_structure_demo.php',
    'hover_removed_demo.php',
    'hero_content_fixed.php',
    'hero_section_fixed.php',
    'products_enhanced.php',
    '.htaccess.original'
];

echo "<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Divyaghar Project Cleanup</title>
<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
.container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.header { background: #2c3e50; color: white; padding: 15px; border-radius: 8px 8px 0; margin-bottom: 20px; text-align: center; }
.header h1 { margin: 0; font-size: 24px; }
.file-list { list-style: none; padding: 0; }
.file-item { background: #f8f9fa; padding: 15px; margin-bottom: 10px; border-radius: 5px; border-left: 4px solid #2c3e50; }
.file-item h3 { margin: 0 0 10px 0; color: #2c3e50; }
.success { color: #28a745; font-weight: bold; }
.error { color: #dc3545; font-weight: bold; }
.btn { background: #2c3e50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 10px 5px; text-decoration: none; }
</style>
</head>
<body>
<div class='container'>
<div class='header'>
<h1>🗑️ Divyaghar Project Cleanup</h1>
<p>Removing unwanted files from project</p>
</div>
<div class='file-list'>
<h3>📁 Files to Remove</h3>";

foreach ($files_to_remove as $file) {
    $file_path = __DIR__ . '/' . $file;
    
    if (file_exists($file_path)) {
        if (unlink($file_path)) {
            echo "<div class='file-item success'>";
            echo "<h4>✅ $file</h4>";
            echo "<span class='success'>Successfully removed</span>";
            echo "</div>";
        } else {
            echo "<div class='file-item error'>";
            echo "<h4>❌ $file</h4>";
            echo "<span class='error'>File not found</span>";
            echo "</div>";
        }
    }
}

echo "</div>";

<div class='action-buttons'>
<a href='index.php' class='btn'>🏠 Back to Project</a>
</div>
</div>
</body>
</html>";
?>
