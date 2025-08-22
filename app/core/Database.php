<?php
// app/core/Database.php
namespace App\Core;

use PDO;
use PDOException;
use App\Core\Response;
use function App\Config\{DB_HOST, DB_NAME, DB_USER, DB_PASS};

class Database {
    private static ?PDO $pdo = null;

    private function __construct() {}

    public static function pdo(): PDO {
        if (self::$pdo === null) {
            try {
                $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4";
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                Response::json(['success'=>false,'message'=>'Database connection failed'], 500);
            }
        }
        return self::$pdo;
    }
}