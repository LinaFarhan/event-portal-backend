<?php
namespace App\Controllers;

use App\Core\Response;
use App\Services\AttendeeService;

class AttendeeController extends BaseController {
    protected $attendeeService;

    public function __construct() {
        parent::__construct();
        $this->attendeeService = new AttendeeService();
    }

    public function index() {
        try {
            $attendees = $this->attendeeService->getAllAttendees();
            Response::json($attendees);
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في جلب بيانات الحضور'], 500);
        }
    }

    public function store() {
        try {
            $data = $this->getRequestData();
            
            $validation = $this->validateAttendeeData($data);
            if (!$validation['isValid']) {
                Response::json(['errors' => $validation['errors']], 422);
                return;
            }

            $attendeeId = $this->attendeeService->createAttendee($data);
            
            Response::json([
                'message' => 'تم إضافة الحضور بنجاح',
                'id' => $attendeeId
            ], 201);
            
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في إضافة الحضور'], 500);
        }
    }

    public function update($id) {
        try {
            $data = $this->getRequestData();
            
            $validation = $this->validateAttendeeData($data, false);
            if (!$validation['isValid']) {
                Response::json(['errors' => $validation['errors']], 422);
                return;
            }

            $this->attendeeService->updateAttendee($id, $data);
            
            Response::json(['message' => 'تم تحديث بيانات الحضور بنجاح']);
            
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في تحديث بيانات الحضور'], 500);
        }
    }

    public function destroy($id) {
        try {
            $this->attendeeService->deleteAttendee($id);
            Response::json(['message' => 'تم حذف الحضور بنجاح']);
        } catch (\Exception $e) {
            Response::json(['error' => 'فشل في حذف الحضور'], 500);
        }
    }

    private function validateAttendeeData($data, $isCreate = true) {
        $errors = [];

        if ($isCreate || isset($data['name'])) {
            if (empty(trim($data['name'] ?? ''))) {
                $errors['name'] = 'الاسم مطلوب';
            }
        }

        if ($isCreate || isset($data['email'])) {
            if (empty($data['email'] ?? '')) {
                $errors['email'] = 'البريد الإلكتروني مطلوب';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'صيغة البريد الإلكتروني غير صحيحة';
            }
        }

        if ($isCreate || isset($data['event_id'])) {
            if (empty($data['event_id'] ?? '')) {
                $errors['event_id'] = 'الفعالية مطلوبة';
            } elseif (!is_numeric($data['event_id'])) {
                $errors['event_id'] = 'معرف الفعالية يجب أن يكون رقماً';
            }
        }

        return [
            'isValid' => empty($errors),
            'errors' => $errors
        ];
    }
}