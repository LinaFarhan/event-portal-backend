<?php
namespace App\Models;

use PDO;

class Speaker extends Model
{
    protected $table = 'speakers';
    protected $primaryKey = 'id';

    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function getSpeakersWithEvents()
    {
        $stmt = $this->db->prepare("
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
        $stmt = $this->db->prepare("
            INSERT INTO event_speakers (event_id, speaker_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$eventId, $speakerId]);
    }

    public function removeFromEvent($speakerId, $eventId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM event_speakers 
            WHERE event_id = ? AND speaker_id = ?
        ");
        return $stmt->execute([$eventId, $speakerId]);
    }

    public function find($id){
        $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=:id");
        $st->execute(['id'=>$id]);
        return $st->fetch() ?: null;
    }

    public function create(array $d): int {
        $st = $this->db->prepare("INSERT INTO {$this->table}(name,email,bio) VALUES(:n,:e,:b)");
        $st->execute([
            'n'=>$d['name'],
            'e'=>$d['email'],
            'b'=>$d['bio'] ?? ''
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function updateOne(int $id, array $d): bool {
        $st = $this->db->prepare("UPDATE {$this->table} SET name=:n,email=:e,bio=:b WHERE id=:id");
        return $st->execute([
            'n'=>$d['name'],
            'e'=>$d['email'],
            'b'=>$d['bio'] ?? '',
            'id'=>$id
        ]);
    }

    public function deleteOne(int $id): bool {
        $st = $this->db->prepare("DELETE FROM {$this->table} WHERE id=:id");
        return $st->execute(['id'=>$id]);
    }
}