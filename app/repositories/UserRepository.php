<?php
// app/repositories/UserRepository.php
namespace App\Repositories;
use App\Models\User;

class UserRepository {
    public function __construct(private User $model = new User()) {}
    public function findByEmail(string $email): ?array { return $this->model->findByEmail($email); }
    public function create(array $data): int { return $this->model->create($data); }
    public function getById(int $id): ?array { return $this->model->getById($id); }
}