<?php
// app/core/Auth.php
namespace App\Core;

use function App\Config\JWT_SECRET;

class Auth {
    public static function login(int $userId, string $role): string {
        Session::start();
        $_SESSION['user_id'] = $userId;
        $_SESSION['role']    = $role;
        $_SESSION['last_activity'] = time();
        $_SESSION['token']   = self::token($userId, $role);
        return $_SESSION['token'];
    }

    public static function logout(): void {
        Session::destroy();
    }

    public static function check(): bool {
        Session::start();
        return isset($_SESSION['user_id']) && Session::valid();
    }

    public static function isAdmin(): bool {
        return self::check() && ($_SESSION['role'] ?? '') === 'admin';
    }

    public static function token(int $userId, string $role): string {
        $payload = base64_encode(json_encode(['uid'=>$userId,'role'=>$role,'iat'=>time()]));
        $sig = hash_hmac('sha256', $payload, JWT_SECRET);
        return $payload.'.'.$sig;
    }

    public static function validateToken(string $token): false|array {
        $parts = explode('.', $token);
        if (count($parts) !== 2) return false;
        [$payload, $sig] = $parts;
        $expected = hash_hmac('sha256', $payload, JWT_SECRET);
        if (!hash_equals($expected, $sig)) return false;
        return json_decode(base64_decode($payload), true);
    }
}