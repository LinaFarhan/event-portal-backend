<?php
// app/config/Config.php( مسار الملف )

namespace App\Config;

// قاعدة البيانات
const DB_HOST = 'localhost';
const DB_NAME = 'event_portal';
const DB_USER = 'root';
const DB_PASS = 'password';

// أمان
const JWT_SECRET = 'your_secret_key';
const SESSION_TIMEOUT = 3600; // ثانية
//...................................
 //حسب الفرونت اند  مهم
const FRONTEND_ORIGIN = 'http://localhost:5173';