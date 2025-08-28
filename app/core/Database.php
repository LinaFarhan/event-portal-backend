<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private $pdo;
    
    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    
    public function getPdo()
    {
        return $this->pdo;
    }
}