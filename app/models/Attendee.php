<?php
namespace App\Models;

use PDO;

class Attendee extends Model {
    protected $table = 'attendees';
    protected $primaryKey = 'id';

    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function getWithEvent($attendeeId) {
        $stmt = $this->db->prepare("
            SELECT a.*, e.title as event_title 
            FROM attendees a 
            LEFT JOIN events e ON a.event_id = e.id 
            WHERE a.id = ?
        ");
        $stmt->execute([$attendeeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEvent($eventId) {
        $stmt = $this->db->prepare("
            SELECT a.* 
            FROM attendees a 
            WHERE a.event_id = ? 
            ORDER BY a.registered_at DESC
        ");
        $stmt->execute([$eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByEvent($eventId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM attendees 
            WHERE event_id = ?
        ");
        $stmt->execute([$eventId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
}