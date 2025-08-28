<?php
namespace App\Views\Api;

use App\Core\Response;

class JsonView
{
    public static function render($data, $statusCode = 200)
    {
        Response::json($data, $statusCode);
    }

    public static function success($message = 'تمت العملية بنجاح', $data = [])
    {
        $response = ['message' => $message];
        if (!empty($data)) {
            $response['data'] = $data;
        }
        self::render($response);
    }

    public static function error($message = 'حدث خطأ', $statusCode = 400, $errors = [])
    {
        $response = ['error' => $message];
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
        self::render($response, $statusCode);
    }

    public static function created($message = 'تم الإنشاء بنجاح', $id = null)
    {
        $response = ['message' => $message];
        if ($id !== null) {
            $response['id'] = $id;
        }
        self::render($response, 201);
    }

    public static function notFound($message = 'العنوان غير موجود')
    {
        self::error($message, 404);
    }

    public static function unauthorized($message = 'غير مصرح')
    {
        self::error($message, 401);
    }

    public static function forbidden($message = 'ممنوع')
    {
        self::error($message, 403);
    }

    public static function validationError($errors, $message = 'خطأ في التحقق من البيانات')
    {
        self::error($message, 422, $errors);
    }
}