<?php
namespace App\Core;

class Response
{
    /*public static function json($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}
 */   
   
public static function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json;charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept');
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    } 

    public static function setStatusCode($code)
    {
        http_response_code($code);
    }

    public static function setHeader($name, $value)
    {
        header("$name: $value");
    }
}