<?php
namespace App\Models;

use App\Core\Database;

class Paiement extends Database
{
    public function create($data)
    {
        $sql = "INSERT INTO paiements (participant_id, formation_id, montant, tranche, date_paiement, mode_paiement, statut)
                VALUES (:participant_id, :formation_id, :montant, :tranche, NOW(), :mode_paiement, 'Payé')";
        return $this->query($sql, $data);
    }

    public function getAll()
    {
        return $this->fetchAll("SELECT * FROM paiements ORDER BY date_paiement DESC");
    }

    public function getByParticipant($id)
    {
        return $this->fetchAll("SELECT * FROM paiements WHERE participant_id = ?", [$id]);
    }

    public function getEtatParFormation()
    {
        $sql = "SELECT f.titre, COUNT(p.id) AS nb_paiements, SUM(p.montant) AS total_encaisse
                FROM paiements p
                JOIN formations f ON f.id = p.formation_id
                GROUP BY f.id";
        return $this->fetchAll($sql);
    }
}