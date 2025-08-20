<?php
namespace Core;

use App\Core\Database;

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    public function getAll()
    {
        return $this->db->query("SELECT * FROM {$this->table}")->findAll();
    }
    
    public function findById($id)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id])->find();
    }
    
    public function create(array $data)
    {
        // Filtrer les données selon les champs remplissables
        $filteredData = array_intersect_key($data, array_flip($this->fillable));
        
        // Préparer les colonnes et les valeurs
        $columns = implode(', ', array_keys($filteredData));
        $placeholders = implode(', ', array_fill(0, count($filteredData), '?'));
        
        // Exécuter la requête
        $this->db->query("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})", array_values($filteredData));
        
        // Retourner l'ID inséré
        return $this->db->lastInsertId();
    }
    
    public function update($id, array $data)
    {
        // Filtrer les données selon les champs remplissables
        $filteredData = array_intersect_key($data, array_flip($this->fillable));
        
        // Préparer les champs à mettre à jour
        $fields = array_map(function($field) {
            return "{$field} = ?";
        }, array_keys($filteredData));
        
        $fieldsString = implode(', ', $fields);
        
        // Ajouter l'ID à la fin des valeurs
        $values = array_values($filteredData);
        $values[] = $id;
        
        // Exécuter la requête
        $this->db->query("UPDATE {$this->table} SET {$fieldsString} WHERE {$this->primaryKey} = ?", $values);
        
        // Retourner le nombre de lignes affectées
        return $this->db->rowCount();
    }
    
    public function delete($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id]);
        return $this->db->rowCount();
    }
    
    public function where($column, $operator, $value = null)
    {
        // Si seulement 2 paramètres sont fournis, considérer que l'opérateur est '='
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        return $this->db->query("SELECT * FROM {$this->table} WHERE {$column} {$operator} ?", [$value])->findAll();
    }
    
    public function count()
    {
        return $this->db->query("SELECT COUNT(*) as count FROM {$this->table}")->find()['count'];
    }
}
