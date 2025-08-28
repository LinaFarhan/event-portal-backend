<?php
namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Auth;
use PDO;

class BaseController
{
    protected $db;
    
    public function __construct()
    {
        global $database;
        $this->db = $database->getPdo();
    }
    
    protected function jsonResponse($data, $statusCode = 200)
    {
        Response::json($data, $statusCode);
    }
    
    protected function getRequestData()
    {
        return Request::getBody();
    }
    
    protected function validateJwt()
    {
        return Auth::validateToken();
    }
    
    protected function validateRequiredFields($data, $requiredFields)
    {
        $errors = [];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $errors[$field] = "حقل {$field} مطلوب";
            }
        }
        
        return $errors;
    }
}