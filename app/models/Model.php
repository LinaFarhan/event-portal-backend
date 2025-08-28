<?php
namespace App\Models;

use PDO;

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute(array_values($data));
        
        return $this->db->lastInsertId();
    }

    public function update($id, array $data)
    {
        $setClause = implode(' = ?, ', array_keys($data)) . ' = ?';
        
        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?");
        
        $values = array_values($data);
        $values[] = $id;
        
        return $stmt->execute($values);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }

    public function where($conditions, $params = [])
    {
        $whereClause = implode(' AND ', array_map(fn($col) => "$col = ?", array_keys($conditions)));
        
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$whereClause}");
        $stmt->execute(array_values($conditions));
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}