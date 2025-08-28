<?php
namespace App\Repositories;

use App\Models\Attendee;
use PDO;

class AttendeeRepository {
    protected $model;

    public function __construct(PDO $db) {
        $this->model = new Attendee($db);
    }

    public function getAll() {
        return $this->model->all();
    }
//اتصال
    public function getAllWithEvents() {
        $stmt = $this->model->db->prepare("
            SELECT a.*, e.title as event_title 
            FROM attendees a 
            LEFT JOIN events e ON a.event_id = e.id 
            ORDER BY a.registered_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->model->db->prepare("
            SELECT a.*, e.title as event_title 
            FROM attendees a 
            LEFT JOIN events e ON a.event_id = e.id 
            WHERE a.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data) {
        return $this->model->create($data);
    }

    public function update($id, array $data) {
        return $this->model->update($id, $data);
    }

    public function delete($id) {
        return $this->model->delete($id);
    }

    public function findByEmail($email) {
        $stmt = $this->model->db->prepare("SELECT * FROM attendees WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEventAttendees($eventId) {
        $stmt = $this->model->db->prepare("
            SELECT a.* 
            FROM attendees a 
            WHERE a.event_id = ? 
            ORDER BY a.registered_at DESC
        ");
        $stmt->execute([$eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}