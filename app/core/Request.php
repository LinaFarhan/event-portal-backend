<?php
namespace App\Core;

class Request
{
    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        
        if ($position === false) {
            return $path;
        }
        
        return substr($path, 0, $position);
    }

    public static function getBody()
    {
        $method = self::getMethod();
        $body = [];

        if ($method === 'GET') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

            if (strpos($contentType, 'application/json') !== false) {
                $json = file_get_contents('php://input');
                $body = json_decode($json, true) ?? [];
            } else {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }

        return $body;
    }

    public static function getHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
                $headers[$header] = $value;
            }
        }
        return $headers;
    }

    public static function getAuthorizationHeader()
    {
        $headers = self::getHeaders();
        return $headers['Authorization'] ?? null;
    }
}