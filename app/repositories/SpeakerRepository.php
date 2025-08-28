<?php
namespace App\Repositories;

use App\Models\Speaker;
use PDO;

class SpeakerRepository
{
    protected $model;

    public function __construct(PDO $db)
    {
        $this->model = new Speaker($db);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function findByEmail($email)
    {
        $stmt = $this->model->db->prepare("SELECT * FROM speakers WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByName($name)
    {
        $stmt = $this->model->db->prepare("SELECT * FROM speakers WHERE name LIKE ?");
        $stmt->execute(["%$name%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSpeakersWithEvents()
    {
        $stmt = $this->model->db->prepare("
            SELECT s.*, GROUP_CONCAT(e.title) as event_titles 
            FROM speakers s 
            LEFT JOIN event_speakers es ON s.id = es.speaker_id 
            LEFT JOIN events e ON es.event_id = e.id 
            GROUP BY s.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToEvent($speakerId, $eventId)
    {
        $stmt = $this->model->db->prepare("
            INSERT INTO event_speakers (event_id, speaker_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$eventId, $speakerId]);
    }

    public function removeFromEvent($speakerId, $eventId)
    {
        $stmt = $this->model->db->prepare("
            DELETE FROM event_speakers 
            WHERE event_id = ? AND speaker_id = ?
        ");
        return $stmt->execute([$eventId, $speakerId]);
    }

    public function getEventSpeakers($eventId)
    {
        $stmt = $this->model->db->prepare("
            SELECT s.* 
            FROM speakers s 
            INNER JOIN event_speakers es ON s.id = es.speaker_id 
            WHERE es.event_id = ?
        ");
        $stmt->execute([$eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}