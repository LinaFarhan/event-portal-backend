<?php
namespace App\Services;

use App\Repositories\UserRepository;
use App\Core\Auth;

class UserService
{
    protected $userRepository;

    public function __construct()
    {
        global $database;
        $this->userRepository = new UserRepository($database->getPdo());
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data)
    {
        // تشفير كلمة المرور
        if (isset($data['password'])) {
            $data['password'] = Auth::hashPassword($data['password']);
        }

        return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data)
    {
        // إذا كانت هناك كلمة مرور جديدة، قم بتشفيرها
        if (isset($data['password'])) {
            $data['password'] = Auth::hashPassword($data['password']);
        }

        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }

    public function findByUsername($username)
    {
        return $this->userRepository->findByUsername($username);
    }

    public function findByEmail($email)
    {
        return $this->userRepository->findByEmail($email);
    }

    public function verifyCredentials($username, $password)
    {
        $user = $this->userRepository->findByUsername($username);
        
        if (!$user) {
            return false;
        }

        return Auth::verifyPassword($password, $user['password']);
    }

    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = Auth::hashPassword($newPassword);
        return $this->userRepository->updatePassword($userId, $hashedPassword);
    }

    public function getUserEvents($userId)
    {
     
        return [];
    }
}