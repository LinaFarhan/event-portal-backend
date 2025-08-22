<?php
// public/index.php
use App\Core\Router;
use App\Core\Response;
use App\Controllers\AuthController;
use App\Controllers\EventController;
use App\Controllers\SpeakerController;
use App\Config as Cfg;

require _DIR_ . '/../vendor/autoload.php';

// CORS (تأكد أن الهيدر قبل أي مخرجات)
header('Access-Control-Allow-Origin: ' . Cfg\FRONTEND_ORIGIN);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$router = new Router();

// Auth
$router->add('POST', '/api/v1/auth/register', [AuthController::class,'register']);
$router->add('POST', '/api/v1/auth/login',    [AuthController::class,'login']);
$router->add('POST', '/api/v1/auth/logout',   [AuthController::class,'logout']);
$router->add('GET',  '/api/v1/auth/check',    [AuthController::class,'check']);

// Events
$router->add('GET',    '/api/v1/events',           [EventController::class,'index']);
$router->add('GET',    '/api/v1/events/{id}',      [EventController::class,'show']);
$router->add('POST',   '/api/v1/events',           [EventController::class,'store']);
$router->add('PUT',    '/api/v1/events/{id}',      [EventController::class,'update']);
$router->add('DELETE', '/api/v1/events/{id}',      [EventController::class,'destroy']);

// Speakers
$router->add('GET',    '/api/v1/speakers',         [SpeakerController::class,'index']);
$router->add('GET',    '/api/v1/speakers/{id}',    [SpeakerController::class,'show']);
$router->add('POST',   '/api/v1/speakers',         [SpeakerController::class,'store']);
$router->add('PUT',    '/api/v1/speakers/{id}',    [SpeakerController::class,'update']);
$router->add('DELETE', '/api/v1/speakers/{id}',    [SpeakerController::class,'destroy']);

$router->run();