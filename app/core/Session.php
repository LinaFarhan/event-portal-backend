<?php
namespace App\Core;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove($key)
    {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        self::start();
        session_destroy();
        $_SESSION = [];
    }

    public static function flash($key, $value = null)
    {
        self::start();
        
        if ($value === null) {
            $value = self::get('flash_' . $key);
            self::remove('flash_' . $key);
            return $value;
        }
        
        self::set('flash_' . $key, $value);
    }

    public static function id()
    {
        self::start();
        return session_id();
    }

    public static function regenerate()
    {
        self::start();
        session_regenerate_id(true);
    }

    public static function getAll()
    {
        self::start();
        return $_SESSION;
    }
}