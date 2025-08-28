<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>اختبار الاتصال بقاعدة البيانات</h2>";

try {
    // تحميل autoloader
    require_once 'app/core/Autoloader.php';
    $autoloader = new App\Core\Autoloader();
    $autoloader->register();
    
    echo "تم تحميل Autoloader<br>";
    
    // تحميل الإعدادات
    $config = require 'app/config/config.php';
    echo " تم تحميل الإعدادات<br>";
    
    // محاولة الاتصال بقاعدة البيانات
    $database = new App\Core\Database($config['database']);
    $pdo = $database->getPdo();
    
    echo " تم الاتصال بقاعدة البيانات بنجاح<br>";
    
    // اختبار استعلام بسيط
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo " الجداول الموجودة: " . (count($tables) > 0 ? implode(', ', $tables) : 'لا توجد جداول') . "<br>";
    
} catch (Exception $e) {
    echo "<div style='color: red;'>";
    echo "خطأ: " . $e->getMessage() . "<br>";
    echo "الملف: " . $e->getFile() . "<br>";
    echo "السطر: " . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}