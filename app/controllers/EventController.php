<?php
// app/controllers/EventController.php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Response;
use App\Services\EventService;

class EventController extends BaseController {
    private EventService $events;

    public function __construct() {
        parent::__construct();
        $this->events = new EventService();
    }

    public function index(): void {
        Response::json(['success'=>true,'data'=>$this->events->all()]);
    }

    public function show($id): void {
        $e = $this->events->get((int)$id);
        if (!$e) Response::json(['success'=>false,'message'=>'الفعالية غير موجودة'], 404);
        Response::json(['success'=>true,'data'=>$e]);
    }

    public function store(): void {
        if (!Auth::isAdmin()) Response::json(['success'=>false,'message'=>'غير مصرح'], 401);
        $id = $this->events->create($this->body());
        Response::json(['success'=>true,'id'=>$id], 201);
    }

    public function update($id): void {
        if (!Auth::isAdmin()) Response::json(['success'=>false,'message'=>'غير مصرح'], 401);
        $ok = $this->events->update((int)$id, $this->body());
        Response::json(['success'=>$ok,'message'=>$ok?'تم التحديث':'لم يتم التحديث']);
    }

    public function destroy($id): void {
        if (!Auth::isAdmin()) Response::json(['success'=>false,'message'=>'غير مصرح'], 401);
        $ok = $this->events->delete((int)$id);
        Response::json(['success'=>$ok,'message'=>$ok?'تم الحذف':'لم يتم الحذف']);
    }
}