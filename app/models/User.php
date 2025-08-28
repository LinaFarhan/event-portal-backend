<?php
namespace App\Models;

use PDO;
class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($userId, $hashedPassword)
    {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $userId]);
    }
}