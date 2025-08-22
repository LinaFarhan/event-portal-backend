<?php
// app/controllers/SpeakerController.php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Response;
use App\Services\SpeakerService;

class SpeakerController extends BaseController {
    private SpeakerService $speakers;

    public function __construct() {
        parent::__construct();
        $this->speakers = new SpeakerService();
    }

    public function index(): void {
        Response::json(['success'=>true,'data'=>$this->speakers->all()]);
    }

    public function show($id): void {
        $s = $this->speakers->get((int)$id);
        if (!$s) Response::json(['success'=>false,'message'=>'المتحدث غير موجود'], 404);
        Response::json(['success'=>true,'data'=>$s]);
    }

    public function store(): void {
        if (!Auth::isAdmin()) Response::json(['success'=>false,'message'=>'غير مصرح'], 401);
        $id = $this->speakers->create($this->body());
        Response::json(['success'=>true,'id'=>$id], 201);
    }

    public function update($id): void {
        if (!Auth::isAdmin()) Response::json(['success'=>false,'message'=>'غير مصرح'], 401);
        $ok = $this->speakers->update((int)$id, $this->body());
        Response::json(['success'=>$ok,'message'=>$ok?'تم التحديث':'لم يتم التحديث']);
    }

    public function destroy($id): void {
        if (!Auth::isAdmin()) Response::json(['success'=>false,'message'=>'غير مصرح'], 401);
        $ok = $this->speakers->delete((int)$id);
        Response::json(['success'=>$ok,'message'=>$ok?'تم الحذف':'لم يتم الحذف']);
    }
}