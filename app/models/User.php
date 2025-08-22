<?php
// app/models/User.php
namespace App\Models;

class User extends Model {
    protected string $table = 'users';

    public function findByEmail(string $email): ?array {
        $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE email=:email LIMIT 1");
        $st->execute(['email'=>$email]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public function create(array $data): int {
        $st = $this->db->prepare("INSERT INTO {$this->table} (username,email,password,role) VALUES (:u,:e,:p,:r)");
        $st->execute([
            'u'=>$data['username'],
            'e'=>$data['email'],
            'p'=>password_hash($data['password'], PASSWORD_DEFAULT),
            'r'=>$data['role'] ?? 'user'
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function getById(int $id): ?array {
        $st = $this->db->prepare("SELECT id,username,email,role FROM {$this->table} WHERE id=:id");
        $st->execute(['id'=>$id]);
        return $st->fetch() ?: null;
    }
}