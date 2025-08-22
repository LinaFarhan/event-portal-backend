<?php
// app/services/UserService.php
namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
    public function __construct(private UserRepository $repo = new UserRepository()) {}

    public function register(array $d): array {
        $id = $this->repo->create($d);
        return $this->repo->getById($id) ?? [];
    }

    public function login(string $email, string $password): false|array {
        $user = $this->repo->findByEmail($email);
        if (!$user) return false;
        return password_verify($password, $user['password']) ? $user : false;
    }
}