<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Response;
use App\Services\UserService;

class AuthController extends BaseController {
    protected $userService;

    public function __construct() {
        parent::__construct();
        $this->userService = new UserService();
    }

    public function login(): void {
        $data = $this->getRequestData();
        
        //  - عرض البيانات المستلمة
        error_log("بيانات الدخول: " . print_r($data, true));
        
        if (empty($data['email']) || empty($data['password'])) {
            Response::json([
                'success' => false,
                'message' => 'البريد الإلكتروني وكلمة المرور مطلوبان'
            ], 400);
            return;
        }

        try {
            // البحث عن المستخدم بالبريد الإلكتروني
            $user = $this->userService->findByEmail($data['email']);
            
            if (!$user) {
                Response::json([
                    'success' => false,
                    'message' => 'البريد الإلكتروني غير مسجل'
                ], 401);
                return;
            }

            // التحقق من كلمة المرور
            if (!Auth::verifyPassword($data['password'], $user['password'])) {
                Response::json([
                    'success' => false,
                    'message' => 'كلمة المرور غير صحيحة'
                ], 401);
                return;
            }

            // إنشاء token
            $token = Auth::generateToken([
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'] ?? 'user'
            ]);

            // إخفاء كلمة المرور من الاستجابة
            unset($user['password']);

            Response::json([
                'success' => true,
                'message' => 'تم تسجيل الدخول بنجاح',
                'token' => $token,
                'user' => $user
            ]);

        } catch (\Exception $e) {
            error_log("خطأ في تسجيل الدخول: " . $e->getMessage());
            
            Response::json([
                'success' => false,
                'message' => 'حدث خطأ في الخادم'
            ], 500);
        }
    }

    public function register(): void {
        $data = $this->getRequestData();
        
        $requiredFields = ['username', 'email', 'password'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            Response::json([
                'success' => false,
                'message' => 'حقول مطلوبة مفقودة',
                'missing_fields' => $missingFields
            ], 422);
            return;
        }

        try {
            // التحقق إذا كان البريد الإلكتروني موجود مسبقاً
            $existingUser = $this->userService->findByEmail($data['email']);
            if ($existingUser) {
                Response::json([
                    'success' => false,
                    'message' => 'البريد الإلكتروني مسجل مسبقاً'
                ], 409);
                return;
            }

            $user = $this->userService->createUser($data);
            
            Response::json([
                'success' => true,
                'message' => 'تم إنشاء الحساب بنجاح',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            error_log("خطأ في التسجيل: " . $e->getMessage());
            
            Response::json([
                'success' => false,
                'message' => 'حدث خطأ في إنشاء الحساب'
            ], 500);
        }
    }

    public function me(): void {
        try {
            $userData = Auth::validateToken();
            
            Response::json([
                'success' => true,
                'user' => $userData
            ]);
            
        } catch (\Exception $e) {
            Response::json([
                'success' => false,
                'message' => 'غير مصرح'
            ], 401);
        }
    }

    public function logout(): void {
        Response::json([
            'success' => true,
            'message' => 'تم تسجيل الخروج'
        ]);
    }
}