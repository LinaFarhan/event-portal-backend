<?php
namespace App\Controllers;

use App\Core\Response;

class ErrorController extends BaseController
{
    public function notFound()
    {
        Response::json([
            'error' => 'الصفحة غير موجودة',
            'message' => 'عذراً، الصفحة التي تبحث عنها غير موجودة.'
        ], 404);
    }

    public function methodNotAllowed()
    {
        Response::json([
            'error' => 'الطريقة غير مسموحة',
            'message' => 'طريقة HTTP المستخدمة غير مسموحة لهذا المسار.'
        ], 405);
    }
    
    public function serverError($message = 'خطأ داخلي في الخادم')
    {
        Response::json([
            'error' => 'خطأ في الخادم',
            'message' => $message
        ], 500);
    }

    public function validationError($errors)
    {
        Response::json([
            'error' => 'خطأ في التحقق',
            'errors' => $errors
        ], 422);
    }

    public function unauthorized()
    {
        Response::json([
            'error' => 'غير مصرح',
            'message' => 'تحتاج إلى تسجيل الدخول للوصول إلى هذا المورد.'
        ], 401);
    }

    public function forbidden()
    {
        Response::json([
            'error' => 'ممنوع',
            'message' => 'ليس لديك الصلاحية للوصول إلى هذا المورد.'
        ], 403);
    }
}