<?php
return [
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'dbname' => $_ENV['DB_NAME'] ?? 'event_management',
        'username' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASS'] ?? '',
        'charset' => 'utf8mb4'
    ],
    'jwt' => [
        'secret' => $_ENV['JWT_SECRET'] ?? 'your-super-secret-jwt-key-change-in-production',
        'algorithm' => 'HS256'
    ],
    'app' => [
        'name' => 'Event Management System',
        'version' => '1.0.0',
        'env' => $_ENV['APP_ENV'] ?? 'development'
    ]
];