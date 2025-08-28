<?php
use App\Controllers\AuthController;
use App\Controllers\EventController;
use App\Controllers\SpeakerController;
use App\Controllers\ErrorController;
use App\Controllers\AttendeeController;

$errorController = new ErrorController();

// مسار رئيسي تجريبي
$router->add('GET', '/', function() {
    echo json_encode([
        'message' => 'مرحباً بك في نظام إدارة الفعاليات',
        'version' => '1.0.0',
        'endpoints' => [
            // الفعاليات
            'GET /api/events'         => 'الحصول على جميع الفعاليات',
            'GET /api/events/{id}'    => 'الحصول على فعالية محددة',
            'POST /api/events'        => 'إنشاء فعالية جديدة',
            'PUT /api/events/{id}'    => 'تحديث فعالية',
            'DELETE /api/events/{id}' => 'حذف فعالية',

            // المتحدثين
            'GET /api/speakers'         => 'الحصول على جميع المتحدثين',
            'GET /api/speakers/{id}'    => 'الحصول على متحدث محدد',
            'POST /api/speakers'        => 'إضافة متحدث جديد',
            'PUT /api/speakers/{id}'    => 'تحديث متحدث',
            'DELETE /api/speakers/{id}' => 'حذف متحدث',

            // الحضور
            'GET /api/attendees'         => 'الحصول على جميع الحضور',
            'POST /api/attendees'        => 'إضافة حضور جديد',
            'PUT /api/attendees/{id}'    => 'تحديث حضور',
            'DELETE /api/attendees/{id}' => 'حذف حضور',

            // تسجيل الدخول و التسجيل
            'POST /api/login'    => 'تسجيل الدخول',   
            'POST /api/register' => 'إنشاء حساب جديد'
        ]
    ]);
});

//  Routes للمصادقة
$router->add('POST', '/api/login', [new AuthController(), 'login']);
$router->add('POST', '/api/register', [new AuthController(), 'register']);
$router->add('GET', '/api/me', [new AuthController(), 'me']);

// Routes للفعاليات
$router->add('GET', '/api/events', [new EventController(), 'index']);
$router->add('GET', '/api/events/(\d+)', [new EventController(), 'show']);
$router->add('POST', '/api/events', [new EventController(), 'store']);
$router->add('PUT', '/api/events/(\d+)', [new EventController(), 'update']);
$router->add('DELETE', '/api/events/(\d+)', [new EventController(), 'destroy']);

//  Routes للمتحدثين
$router->add('GET', '/api/speakers', [new SpeakerController(), 'index']);
$router->add('GET', '/api/speakers/(\d+)', [new SpeakerController(), 'show']);
$router->add('POST', '/api/speakers', [new SpeakerController(), 'store']);
$router->add('PUT', '/api/speakers/(\d+)', [new SpeakerController(), 'update']);
$router->add('DELETE', '/api/speakers/(\d+)', [new SpeakerController(), 'destroy']);

// Routes للحضور
$router->add('GET', '/api/attendees', [new AttendeeController(), 'index']);
$router->add('POST', '/api/attendees', [new AttendeeController(), 'store']);
$router->add('PUT', '/api/attendees/(\d+)', [new AttendeeController(), 'update']);
$router->add('DELETE', '/api/attendees/(\d+)', [new AttendeeController(), 'destroy']);

//  Route لـ OPTIONS (CORS)
$router->add('OPTIONS', '/.*', function() {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept');
    echo json_encode(['message' => 'OK']);
});

// Routes للأخطاء
$router->add('GET', '/404', [$errorController, 'notFound']);
$router->set404([$errorController, 'notFound']);