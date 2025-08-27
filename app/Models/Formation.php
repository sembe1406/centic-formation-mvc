<?php
namespace App\Models;

use Core\Model;

class Formation extends Model
{
    protected $table = 'Formation';
    protected $primaryKey = 'id_formation';
    protected $fillable = [
        'titre', 'description', 'date_debut', 'date_fin', 'prix'
    ];
    
    /**
     * Récupérer les dernières formationss
     * 
     * @param int $limit Nombre de formations à récupérer
     * @return array Liste des formations
     */
    public function getLatest($limit = 5)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY date_debut DESC LIMIT ?", 
            [$limit]
        )->findAll();
    }
    
    /**
     * Récupérer les formations à venir
     * 
     * @param int $limit Nombre de formations à récupérer
     * @return array Liste des formations
     */
    public function getUpcoming($limit = 5)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} 
             WHERE date_debut >= CURDATE() 
             ORDER BY date_debut ASC 
             LIMIT ?", 
            [$limit]
        )->findAll();
    }
    
    /**
     * Récupérer les formateurs d'une formation
     * 
     * @param int $id ID de la formation
     * @return array Liste des formateurs
     */
    public function getFormateurs($id)
    {
        return $this->db->query(
            "SELECT f.* FROM Formateur f
             JOIN Dispense d ON f.id_formateur = d.id_formateur
             WHERE d.id_formation = ?",
            [$id]
        )->findAll();
    }
    
    /**
     * Récupérer les séances d'une formation
     * 
     * @param int $id ID de la formation
     * @return array Liste des séances
     */
    public function getSeances($id)
    {
        return $this->db->query(
            "SELECT * FROM Seance WHERE id_formation = ? ORDER BY date_session ASC",
            [$id]
        )->findAll();
    }
    
    /**
     * Compter le nombre de participants inscrits à une formation
     * 
     * @param int $id ID de la formation
     * @return int Nombre de participants
     */
    public function countParticipants($id)
    {
        return $this->db->query(
            "SELECT COUNT(*) as count FROM Inscription WHERE id_formation = ?",
            [$id]
        )->find()['count'];
    }
        /**
     * Ajouter une nouvelle formation
     *
     * @param array $data Données de la formation
     * @return bool True si succès, false sinon
     */
    public function addFormation(array $data) 
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Mettre à jour une formation existante
     *
     * @param int $id ID de la formation
     * @param array $data Données à mettre à jour
     * @return bool True si succès, false sinon
     */
    public function updateFormation(int $id, array $data)
    {
        return $this->db->update($this->table, $data, [$this->primaryKey => $id]);
    }

    /**
     * Supprimer une formation
     *
     * @param int $id ID de la formation
     * @return bool True si succès, false sinon
     */
    public function deleteFormation(int $id)
    {
        return $this->db->delete($this->table, [$this->primaryKey => $id]);
    }
  
}