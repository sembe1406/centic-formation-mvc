<?php
// Connexion à la base
$pdo = new PDO('mysql:host=localhost;dbname=ta_base', 'utilisateur', 'motdepasse');

// Fonction pour enregistrer un paiement
function ajouterPaiement($participant_id, $type, $montant, $date) {
    global $pdo;
    $sql = "INSERT INTO paiements (participant_id, type, montant, date) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$participant_id, $type, $montant, $date]);
}

// Fonction pour récupérer tous les paiements
function getPaiements() {
    global $pdo;
    $sql = "SELECT p.*, part.nom FROM paiements p JOIN participants part ON p.participant_id = part.id ORDER BY p.date DESC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les participants
function getParticipants() {
    global $pdo;
    $sql = "SELECT id, nom FROM participants ORDER BY nom";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
?>