<?php
namespace App\Services;

class ValidationService
{
    public function validateEventData($data, $isCreate = true)
    {
        $errors = [];

        if ($isCreate || isset($data['title'])) {
            if (empty(trim($data['title'] ?? ''))) {
                $errors['title'] = 'عنوان الفعالية مطلوب';
            } elseif (strlen($data['title']) > 255) {
                $errors['title'] = 'عنوان الفعالية يجب أن لا يتجاوز 255 حرفاً';
            }
        }

        if ($isCreate || isset($data['date'])) {
            if (empty($data['date'] ?? '')) {
                $errors['date'] = 'تاريخ الفعالية مطلوب';
            } elseif (!$this->isValidDate($data['date'])) {
                $errors['date'] = 'صيغة التاريخ غير صحيحة';
            }
        }

        if ($isCreate || isset($data['time'])) {
            if (empty($data['time'] ?? '')) {
                $errors['time'] = 'وقت الفعالية مطلوب';
            } elseif (!$this->isValidTime($data['time'])) {
                $errors['time'] = 'صيغة الوقت غير صحيحة';
            }
        }

        if ($isCreate || isset($data['location'])) {
            if (empty(trim($data['location'] ?? ''))) {
                $errors['location'] = 'مكان الفعالية مطلوب';
            }
        }

        if (isset($data['description']) && strlen($data['description']) > 1000) {
            $errors['description'] = 'الوصف يجب أن لا يتجاوز 1000 حرف';
        }

        return [
            'isValid' => empty($errors),
            'errors' => $errors
        ];
    }

    public function validateSpeakerData($data, $isCreate = true)
    {
        $errors = [];

        if ($isCreate || isset($data['name'])) {
            if (empty(trim($data['name'] ?? ''))) {
                $errors['name'] = 'اسم المتحدث مطلوب';
            } elseif (strlen($data['name']) > 100) {
                $errors['name'] = 'اسم المتحدث يجب أن لا يتجاوز 100 حرف';
            }
        }

        if ($isCreate || isset($data['email'])) {
            if (empty($data['email'] ?? '')) {
                $errors['email'] = 'البريد الإلكتروني مطلوب';
            } elseif (!$this->isValidEmail($data['email'])) {
                $errors['email'] = 'صيغة البريد الإلكتروني غير صحيحة';
            }
        }

        if (isset($data['phone']) && !empty($data['phone']) && !$this->isValidPhone($data['phone'])) {
            $errors['phone'] = 'صيغة رقم الهاتف غير صحيحة';
        }

        if (isset($data['expertise']) && strlen($data['expertise']) > 255) {
            $errors['expertise'] = 'التخصص يجب أن لا يتجاوز 255 حرف';
        }

        if (isset($data['bio']) && strlen($data['bio']) > 500) {
            $errors['bio'] = 'السيرة الذاتية يجب أن لا تتجاوز 500 حرف';
        }

        return [
            'isValid' => empty($errors),
            'errors' => $errors
        ];
    }

    public function validateUserData($data, $isCreate = true)
    {
        $errors = [];

        if ($isCreate || isset($data['username'])) {
            if (empty(trim($data['username'] ?? ''))) {
                $errors['username'] = 'اسم المستخدم مطلوب';
            } elseif (strlen($data['username']) < 3) {
                $errors['username'] = 'اسم المستخدم يجب أن يكون على الأقل 3 أحرف';
            } elseif (strlen($data['username']) > 50) {
                $errors['username'] = 'اسم المستخدم يجب أن لا يتجاوز 50 حرف';
            }
        }

        if ($isCreate || isset($data['email'])) {
            if (empty($data['email'] ?? '')) {
                $errors['email'] = 'البريد الإلكتروني مطلوب';
            } elseif (!$this->isValidEmail($data['email'])) {
                $errors['email'] = 'صيغة البريد الإلكتروني غير صحيحة';
            }
        }

        if ($isCreate || isset($data['password'])) {
            if ($isCreate && empty($data['password'] ?? '')) {
                $errors['password'] = 'كلمة المرور مطلوبة';
            } elseif (!empty($data['password']) && strlen($data['password']) < 6) {
                $errors['password'] = 'كلمة المرور يجب أن تكون على الأقل 6 أحرف';
            }
        }

        return [
            'isValid' => empty($errors),
            'errors' => $errors
        ];
    }

    public function validateAttendeeData($data)
    {
        $errors = [];

        if (empty(trim($data['name'] ?? ''))) {
            $errors['name'] = 'اسم الحضور مطلوب';
        }

        if (empty($data['email'] ?? '')) {
            $errors['email'] = 'البريد الإلكتروني مطلوب';
        } elseif (!$this->isValidEmail($data['email'])) {
            $errors['email'] = 'صيغة البريد الإلكتروني غير صحيحة';
        }

        if (empty($data['event_id'] ?? '')) {
            $errors['event_id'] = 'معرف الفعالية مطلوب';
        } elseif (!is_numeric($data['event_id'])) {
            $errors['event_id'] = 'معرف الفعالية يجب أن يكون رقماً';
        }

        if (isset($data['phone']) && !empty($data['phone']) && !$this->isValidPhone($data['phone'])) {
            $errors['phone'] = 'صيغة رقم الهاتف غير صحيحة';
        }

        return [
            'isValid' => empty($errors),
            'errors' => $errors
        ];
    }

    private function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isValidPhone($phone)
    {
        return preg_match('/^05\d{8}$/', $phone) === 1;
    }

    private function isValidDate($date)
    {
        return strtotime($date) !== false;
    }

    private function isValidTime($time)
    {
        return preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $time) === 1;
    }
}