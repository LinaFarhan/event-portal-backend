<?php
namespace App\Core;

class Autoloader
{
    public function register()
    {
        spl_autoload_register([$this, 'autoload']);
    }
    
    public function autoload($className)
    {
        // تحويل namespace إلى مسار ملف
        $className = str_replace('App\\', '', $className);
        $file = __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
//stander name