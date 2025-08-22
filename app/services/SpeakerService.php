<?php
// app/services/SpeakerService.php
namespace App\Services;

use App\Repositories\SpeakerRepository;

class SpeakerService {
    public function __construct(private SpeakerRepository $repo = new SpeakerRepository()) {}
    public function all(): array { return $this->repo->all(); }
    public function get(int $id): ?array { return $this->repo->find($id); }
    public function create(array $d): int { return $this->repo->create($d); }
    public function update(int $id, array $d): bool { return $this->repo->update($id,$d); }
    public function delete(int $id): bool { return $this->repo->delete($id); }
}