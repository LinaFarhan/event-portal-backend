<?php
namespace App\Repositories;

use App\Models\User;
use PDO;

class UserRepository
{
    protected $model;

    public function __construct(PDO $db)
    {
        $this->model = new User($db);
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

    public function findByUsername($username)
    {
        return $this->model->findByUsername($username);
    }

    public function findByEmail($email)
    {
        return $this->model->findByEmail($email);
    }

    public function updatePassword($userId, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->model->updatePassword($userId, $hashedPassword);
    }
}