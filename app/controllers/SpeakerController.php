<?php
namespace App\Controllers;

use App\Core\Response;
use App\Services\SpeakerService;
use App\Services\ValidationService;

class SpeakerController extends BaseController
{
    protected $speakerService;
    protected $validationService;

    public function __construct()
    {
        parent::__construct();
        $this->speakerService = new SpeakerService();
        $this->validationService = new ValidationService();
    }

    public function index()
    {
        try {
            $speakers = $this->speakerService->getAllSpeakers();
            Response::json($speakers);
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في جلب بيانات المتحدثين'], 500);
        }
    }

    public function show($id)
    {
        try {
            $speaker = $this->speakerService->getSpeakerById($id);
            
            if (!$speaker) {
                Response::json(['error' => 'المتحدث غير موجود'], 404);
                return;
            }

            Response::json($speaker);
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في جلب بيانات المتحدث'], 500);
        }
    }

    public function store()
    {
        try {
            $data = $this->getRequestData();
            
            // التحقق من البيانات
            $validation = $this->validationService->validateSpeakerData($data);
            if (!$validation['isValid']) {
                Response::json(['errors' => $validation['errors']], 422);
                return;
            }

            $speakerId = $this->speakerService->createSpeaker($data);
            
            Response::json([
                'message' => 'تم إضافة المتحدث بنجاح',
                'id' => $speakerId
            ], 201);
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في إضافة المتحدث'], 500);
        }
    }

    public function update($id)
    {
        try {
            $data = $this->getRequestData();
            
            // التحقق من وجود المتحدث
            $existingSpeaker = $this->speakerService->getSpeakerById($id);
            if (!$existingSpeaker) {
                Response::json(['error' => 'المتحدث غير موجود'], 404);
                return;
            }

            // التحقق من البيانات
            $validation = $this->validationService->validateSpeakerData($data, false);
            if (!$validation['isValid']) {
                Response::json(['errors' => $validation['errors']], 422);
                return;
            }

            $this->speakerService->updateSpeaker($id, $data);
            
            Response::json(['message' => 'تم تحديث بيانات المتحدث بنجاح']);
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في تحديث بيانات المتحدث'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // التحقق من وجود المتحدث
            $existingSpeaker = $this->speakerService->getSpeakerById($id);
            if (!$existingSpeaker) {
                Response::json(['error' => 'المتحدث غير موجود'], 404);
                return;
            }

            $this->speakerService->deleteSpeaker($id);
            
            Response::json(['message' => 'تم حذف المتحدث بنجاح']);
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في حذف المتحدث'], 500);
        }
    }

    public function addToEvent($speakerId, $eventId)
    {
        try {
            $result = $this->speakerService->addToEvent($speakerId, $eventId);
            
            if ($result) {
                Response::json(['message' => 'تم إضافة المتحدث إلى الفعالية بنجاح']);
            } else {
                Response::json(['error' => 'فشل في إضافة المتحدث إلى الفعالية'], 500);
            }
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في إضافة المتحدث إلى الفعالية'], 500);
        }
    }

    public function removeFromEvent($speakerId, $eventId)
    {
        try {
            $result = $this->speakerService->removeFromEvent($speakerId, $eventId);
            
            if ($result) {
                Response::json(['message' => 'تم إزالة المتحدث من الفعالية بنجاح']);
            } else {
                Response::json(['error' => 'فشل في إزالة المتحدث من الفعالية'], 500);
            }
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في إزالة المتحدث من الفعالية'], 500);
        }
    }
}