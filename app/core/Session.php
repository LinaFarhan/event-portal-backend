<?php
// app/core/Session.php
namespace App\Core;

use function App\Config\SESSION_TIMEOUT;

class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_httponly' => true,
                'cookie_secure'   => isset($_SERVER['HTTPS']),
                'cookie_samesite' => 'None', //     دومينين مختلفين مع withCredentials
            ]);
        }
        $_SESSION['last_activity'] = $_SESSION['last_activity'] ?? time();
    }

    public static function valid(): bool {
        if (!isset($_SESSION['last_activity'])) return false;
        if ((time() - $_SESSION['last_activity']) > SESSION_TIMEOUT) {
            self::destroy();
            return false;
        }
        $_SESSION['last_activity'] = time();
        return true;
    }

    public static function destroy(): void {
        session_unset();
        session_destroy();
    }
}