<?php
namespace App\Core;

class JSON
{
    public static function encode($data, $options = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($data, $options);
    }

    public static function decode($json, $associative = true)
    {
        return json_decode($json, $associative);
    }

    public static function isValid($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public static function prettyPrint($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function getLastError()
    {
        return json_last_error_msg();
    }
}