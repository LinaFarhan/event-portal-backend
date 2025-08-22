<?php
// app/models/Event.php
namespace App\Models;

class Event extends Model {
    protected string $table = 'events';

    public function all(): array {
        $st = $this->db->query("SELECT * FROM {$this->table} ORDER BY start_date ASC");
        return $st->fetchAll();
    }

    public function find(int $id): ?array {
        $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=:id");
        $st->execute(['id'=>$id]);
        return $st->fetch() ?: null;
    }

    public function create(array $d): int {
        $st = $this->db->prepare(
            "INSERT INTO {$this->table}(title,description,start_date,end_date,audience_type)
             VALUES(:t,:desc,:sd,:ed,:aud)"
        );
        $st->execute([
            't'=>$d['title'],
            'desc'=>$d['description'] ?? '',
            'sd'=>$d['start_date'],
            'ed'=>$d['end_date'],
            'aud'=>$d['audience_type'] ?? 'general'
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function updateOne(int $id, array $d): bool {
        $st = $this->db->prepare(
            "UPDATE {$this->table} SET title=:t, description=:desc, start_date=:sd, end_date=:ed, audience_type=:aud WHERE id=:id"
        );
        return $st->execute([
            't'=>$d['title'],
            'desc'=>$d['description'] ?? '',
            'sd'=>$d['start_date'],
            'ed'=>$d['end_date'],
            'aud'=>$d['audience_type'] ?? 'general',
            'id'=>$id
        ]);
    }

    public function deleteOne(int $id): bool {
        $st = $this->db->prepare("DELETE FROM {$this->table} WHERE id=:id");
        return $st->execute(['id'=>$id]);
    }
}