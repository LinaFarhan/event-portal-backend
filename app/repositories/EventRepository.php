<?php
// app/repositories/EventRepository.php
namespace App\Repositories;
use App\Models\Event;

class EventRepository {
    public function __construct(private Event $model = new Event()) {}
    public function all(): array { return $this->model->all(); }
    public function find(int $id): ?array { return $this->model->find($id); }
    public function create(array $d): int { return $this->model->create($d); }
    public function update(int $id, array $d): bool { return $this->model->updateOne($id,$d); }
    public function delete(int $id): bool { return $this->model->deleteOne($id); }
}