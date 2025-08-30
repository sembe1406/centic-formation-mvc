<?php
namespace App\Models;

// Utiliser le namespace complet pour éviter les conflits
use Core\Model as BaseModel;

class User extends BaseModel
{
    protected $table = 'Utilisateur';
    protected $primaryKey = 'id_utilisateur';
    protected $fillable = [
        'nom_utilisateur', 'email', 'mot_de_passe', 'role', 'est_actif'
    ];

    /**
     * Trouver un utilisateur par son nom d'utilisateur
     * 
     * @param string $username Nom d'utilisateur
     * @return array|false Données de l'utilisateur ou false si non trouvé
     */
    public function findByUsername($username)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE nom_utilisateur = ?", [$username])->find();
    }

    /**
     * Trouver un utilisateur par son email
     * 
     * @param string $email Email de l'utilisateur
     * @return array|false Données de l'utilisateur ou false si non trouvé
     */
    public function findByEmail($email)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE email = ?", [$email])->find();
    }

    /**
     * Mettre à jour la dernière connexion de l'utilisateur
     * 
     * @param int $id ID de l'utilisateur
     * @return bool Succès de l'opération
     */
    public function updateLastLogin($id)
    {
        return $this->db->query(
            "UPDATE {$this->table} SET derniere_connexion = NOW() WHERE {$this->primaryKey} = ?", 
            [$id]
        )->rowCount() > 0;
    }

    /**
     * Vérifier si l'utilisateur est administrateur
     * 
     * @param int $id ID de l'utilisateur
     * @return bool True si l'utilisateur est administrateur
     */
    public function isAdmin($id)
    {
        $user = $this->findById($id);
        return $user && $user['role'] === 'admin';
    }

    /**
     * Vérifier si l'utilisateur est formateur
     * 
     * @param int $id ID de l'utilisateur
     * @return bool True si l'utilisateur est formateur
     */
    public function isFormateur($id)
    {
        $user = $this->findById($id);
        return $user && $user['role'] === 'formateur';
    }

    /**
     * Vérifier si l'utilisateur est participant
     * 
     * @param int $id ID de l'utilisateur
     * @return bool True si l'utilisateur est participant
     */
    public function isParticipant($id)
    {
        $user = $this->findById($id);
        return $user && $user['role'] === 'participant';
    }

    /**
     * Associer un utilisateur à un participant
     * 
     * @param int $userId ID de l'utilisateur
     * @param int $participantId ID du participant
     * @return bool Succès de l'opération
     */
    public function linkToParticipant($userId, $participantId)
    {
        return $this->db->query(
            "INSERT INTO Utilisateur_Participant (id_utilisateur, id_participant) VALUES (?, ?)",
            [$userId, $participantId]
        )->rowCount() > 0;
    }

    /**
     * Associer un utilisateur à un formateur
     * 
     * @param int $userId ID de l'utilisateur
     * @param int $formateurId ID du formateur
     * @return bool Succès de l'opération
     */
    public function linkToFormateur($userId, $formateurId)
    {
        return $this->db->query(
            "INSERT INTO Utilisateur_Formateur (id_utilisateur, id_formateur) VALUES (?, ?)",
            [$userId, $formateurId]
        )->rowCount() > 0;
    }

    /**
     * Obtenir le participant lié à un utilisateur
     * 
     * @param int $userId ID de l'utilisateur
     * @return array|false Données du participant ou false si non trouvé
     */
    public function getLinkedParticipant($userId)
    {
        return $this->db->query(
            "SELECT p.* FROM Participant p 
            JOIN Utilisateur_Participant up ON p.id_participant = up.id_participant 
            WHERE up.id_utilisateur = ?",
            [$userId]
        )->find();
    }

    /**
     * Obtenir le formateur lié à un utilisateur
     * 
     * @param int $userId ID de l'utilisateur
     * @return array|false Données du formateur ou false si non trouvé
     */
    public function getLinkedFormateur($userId)
    {
        return $this->db->query(
            "SELECT f.* FROM Formateur f 
            JOIN Utilisateur_Formateur uf ON f.id_formateur = uf.id_formateur 
            WHERE uf.id_utilisateur = ?",
            [$userId]
        )->find();
    }
}
