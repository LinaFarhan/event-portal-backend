<?php
namespace App\Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    private static $secretKey;
    private static $algorithm = 'HS256';

    public static function init()
    {
        self::$secretKey = $_ENV['JWT_SECRET'] ?? 'your-secret-key';
    }

    public static function generateToken($payload)
    {
        self::init();
        
        $issuedAt = time();
        $expirationTime = $issuedAt + (60 * 60 * 24); // token valid for 24 hours

        $tokenPayload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $payload
        ];

        return JWT::encode($tokenPayload, self::$secretKey, self::$algorithm);
    }

    public static function validateToken()
    {
        self::init();
        
        $token = self::getBearerToken();
        
        if (!$token) {
            Response::json(['error' => 'Token is required'], 401);
            exit;
        }

        try {
            $decoded = JWT::decode($token, new Key(self::$secretKey, self::$algorithm));
            return (array) $decoded->data;
        } catch (\Exception $e) {
            Response::json(['error' => 'Invalid or expired token'], 401);
            exit;
        }
    }

    private static function getBearerToken()
    {
        $headers = Request::getAuthorizationHeader();
        
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}