<?php
// app/models/Speaker.php
namespace App\Models;

class Speaker extends Model {
    protected string $table = 'speakers';

    public function all(): array {
        $st = $this->db->query("SELECT * FROM {$this->table} ORDER BY name ASC");
        return $st->fetchAll();
    }

    public function find(int $id): ?array {
        $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=:id");
        $st->execute(['id'=>$id]);
        return $st->fetch() ?: null;
    }

    public function create(array $d): int {
        $st = $this->db->prepare("INSERT INTO {$this->table}(name,email,bio) VALUES(:n,:e,:b)");
        $st->execute(['n'=>$d['name'],'e'=>$d['email'],'b'=>$d['bio'] ?? '']);
        return (int)$this->db->lastInsertId();
    }

    public function updateOne(int $id, array $d): bool {
        $st = $this->db->prepare("UPDATE {$this->table} SET name=:n,email=:e,bio=:b WHERE id=:id");
        return $st->execute(['n'=>$d['name'],'e'=>$d['email'],'b'=>$d['bio'] ?? '','id'=>$id]);
    }

    public function deleteOne(int $id): bool {
        $st = $this->db->prepare("DELETE FROM {$this->table} WHERE id=:id");
        return $st->execute(['id'=>$id]);
    }
}