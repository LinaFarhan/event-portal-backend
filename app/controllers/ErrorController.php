<?php
namespace App\Controllers;

use App\Core\Json;

class ErrorController {
    public function notFound() {
        Json::send([
            'success' => false,
            'error' => 'Page Not Found',
            'code' => 404
        ], 404);
    }

    public function internalError($message = "Internal Server Error") {
        Json::send([
            'success' => false,
            'error' => $message,
            'code' => 500
        ], 500);
    }

    public function customError($code, $message) {
        Json::send([
            'success' => false,
            'error' => $message,
            'code' => $code
        ], $code);
    }
}