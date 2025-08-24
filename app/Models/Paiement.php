<?php
class Paiement {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ajouterPaiement($id_inscription, $montant, $mode, $type_paiement, $date_paiement) {
        $sql = "INSERT INTO Paiement (id_inscription, montant, mode, type_paiement, date_paiement)
                VALUES (:id_inscription, :montant, :mode, :type_paiement, :date_paiement)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_inscription' => $id_inscription,
            ':montant' => $montant,
            ':mode' => $mode,
            ':type_paiement' => $type_paiement,
            ':date_paiement' => $date_paiement
        ]);
    }

    public function getAllPaiements() {
        $sql = "SELECT p.*, pa.nom, pa.prenom, f.titre
                FROM Paiement p
                JOIN Inscription i ON p.id_inscription = i.id_inscription
                JOIN Participant pa ON i.id_participant = pa.id_participant
                JOIN Formation f ON i.id_formation = f.id_formation
                ORDER BY p.date_paiement DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
