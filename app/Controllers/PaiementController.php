<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $participant_id = $_POST['participant_id'];
    $type = $_POST['type'];
    $montant = $_POST['montant'];
    $date = $_POST['date'];

    if ($montant <= 0) {
        die("Le montant doit être supérieur à zéro.");
    }

    $stmt = $pdo->prepare("INSERT INTO paiements (participant_id, type, montant, date, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$participant_id, $type, $montant, $date]);

    echo "✅ Paiement enregistré avec succès.<br>";
    echo "<a href='liste_paiements.php'>Voir la liste des paiements</a>";
}
?>
