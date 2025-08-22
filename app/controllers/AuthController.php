<?php
// app/controllers/AuthController.php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Response;
use App\Services\UserService;

class AuthController extends BaseController {
    private UserService $users;

    public function __construct() {
        parent::__construct();
        $this->users = new UserService();
    }

    public function register(): void {
        $d = $this->body();
        if (empty($d['username']) || empty($d['email']) || empty($d['password'])) {
            Response::json(['success'=>false,'message'=>'حقول مطلوبة مفقودة'], 422);
        }
        $user = $this->users->register($d);
        Response::json(['success'=>true,'message'=>'تم التسجيل','user'=>$user], 201);
    }

    public function login(): void {
        $d = $this->body();
        if (empty($d['email']) || empty($d['password'])) {
            Response::json(['success'=>false,'message'=>'أدخل البريد وكلمة المرور'], 400);
        }
        $user = $this->users->login($d['email'], $d['password']);
        if (!$user) Response::json(['success'=>false,'message'=>'بيانات الدخول غير صحيحة'], 401);
        $token = Auth::login((int)$user['id'], $user['role']);
        unset($user['password']);
        Response::json(['success'=>true,'message'=>'تم تسجيل الدخول','user'=>$user,'token'=>$token]);
    }

    public function logout(): void {
        Auth::logout();
        Response::json(['success'=>true,'message'=>'تم تسجيل الخروج']);
    }

    public function check(): void {
        Response::json(['success'=>Auth::check()]);
    }
}