<?php
namespace App\Services;

use App\Repositories\AttendeeRepository;

class AttendeeService {
    protected $attendeeRepository;

    public function __construct() {
        global $database;
        $this->attendeeRepository = new AttendeeRepository($database->getPdo());
    }

    public function getAllAttendees() {
        return $this->attendeeRepository->getAllWithEvents();
    }

    public function createAttendee(array $data) {
        return $this->attendeeRepository->create($data);
    }

    public function updateAttendee($id, array $data) {
        return $this->attendeeRepository->update($id, $data);
    }

    public function deleteAttendee($id) {
        return $this->attendeeRepository->delete($id);
    }

    public function getAttendeeById($id) {
        return $this->attendeeRepository->findById($id);
    }
}