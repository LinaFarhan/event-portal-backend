 <?php
// تمكين عرض الأخطاء (فقط أثناء التطوير)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CORS: 
header('Access-Control-Allow-Origin: http://localhost:5173'); // غيّريها للدومين لما ترفعي
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

// التعامل مع طلبات preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// تحميل Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

// تحميل environment variables إذا كان الملف موجود
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} else {
    // قيم افتراضية
    putenv('DB_HOST=localhost');
    putenv('DB_NAME=event_management');
    putenv('DB_USER=root');
    putenv('DB_PASS=');
    putenv('JWT_SECRET=your-super-secret-jwt-key-change-in-production');
}

// Set timezone
date_default_timezone_set('Asia/Riyadh');

//   رسالة اختبار عند فتح الرابط الأساسي
if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '') {
    header('Content-Type: application/json');
    echo json_encode([
        "message" => "🧐😎😤 Backend API is running successfully!",
        "status"  => "OK",
        "time"    => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// تحميل Autoloader
require_once __DIR__ . '/../app/core/Autoloader.php';

// Initialize Autoloader
$autoloader = new App\Core\Autoloader();
$autoloader->register();

// Load configuration
$config = require_once __DIR__ . '/../app/config/config.php';

// Initialize application
try {
    $database = new App\Core\Database($config['database']);
    $router = new App\Core\Router();

    // Load routes
    $routesPath = __DIR__ . '/../app/config/routes.php';
    if (file_exists($routesPath)) {
        require_once $routesPath;
    } else {
        throw new Exception("Routes file not found: " . $routesPath);
    }

    // Dispatch the request
    $router->dispatch();

} catch (Exception $e) {
    // عرض الخطأ بالتفصيل
    header('Content-Type: application/json');
    http_response_code(500);

    $errorResponse = [
        'error'   => 'Internal Server Error',
        'message' => $e->getMessage(),
        'file'    => $e->getFile(),
        'line'    => $e->getLine(),
        'type'    => get_class($e)
    ];

    if (getenv('APP_ENV') === 'development') {
        $errorResponse['trace'] = $e->getTrace();
    }

    echo json_encode($errorResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}