<?php
namespace App\Services;

class ValidationService {

    public static function required($value) {
        return !empty(trim($value));
    }

    public static function email($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function minLength($value, $length) {
        return strlen(trim($value)) >= $length;
    }

    public static function maxLength($value, $length) {
        return strlen(trim($value)) <= $length;
    }

    public static function validate($data, $rules) {
        $errors = [];
        foreach($rules as $field => $checks) {
            foreach($checks as $check => $value) {
                switch($check) {
                    case 'required':
                        if(!self::required($data[$field] ?? '')) {
                            $errors[$field][] = "$field is required";
                        }
                        break;
                    case 'email':
                        if($value && !self::email($data[$field] ?? '')) {
                            $errors[$field][] = "$field must be a valid email";
                        }
                        break;
                    case 'min':
                        if(!self::minLength($data[$field] ?? '', $value)) {
                            $errors[$field][] = "$field minimum length is $value";
                        }
                        break;
                    case 'max':
                        if(!self::maxLength($data[$field] ?? '', $value)) {
                            $errors[$field][] = "$field maximum length is $value";
                        }
                        break;
                }
            }
        }
        return $errors;
    }
}