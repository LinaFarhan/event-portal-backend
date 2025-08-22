<?php
// app/models/Model.php
namespace App\Models;

use App\Core\Database;
use PDO;

abstract class Model {
    protected PDO $db;
    protected string $table;

    public function __construct() {
        $this->db = Database::pdo();
    }
}