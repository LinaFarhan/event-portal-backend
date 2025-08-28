<?php
namespace App\Models;
use PDO;
class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';

    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function getWithSpeakers($eventId)
    {
        $stmt = $this->db->prepare("
            SELECT e.*, GROUP_CONCAT(s.name) as speaker_names 
            FROM events e 
            LEFT JOIN event_speakers es ON e.id = es.event_id 
            LEFT JOIN speakers s ON es.speaker_id = s.id 
            WHERE e.id = ? 
            GROUP BY e.id
        ");
        $stmt->execute([$eventId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUpcomingEvents()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM events 
            WHERE date >= CURDATE() 
            ORDER BY date, time
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventsByUser($userId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM events 
            WHERE created_by = ? 
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}