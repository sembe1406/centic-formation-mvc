<?php
// ===== Connexion à la base =====
$pdo = new PDO("mysql:host=localhost;dbname=centic_formation;charset=utf8", "root", "");

// Récupérer la liste des formations pour la liste déroulante
$formations = $pdo->query("SELECT * FROM formations")->fetchAll(PDO::FETCH_ASSOC);

// Message de confirmation
$message = "";

// ===== Traitement du formulaire =====
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1. Insérer le participant
    $stmt = $pdo->prepare("INSERT INTO participants (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['telephone']
    ]);
    $participantId = $pdo->lastInsertId();

    // 2. Insérer l'inscription
    $stmt = $pdo->prepare("INSERT INTO inscriptions (participant_id, formation_id, date_inscription) VALUES (?, ?, ?)");
    $stmt->execute([
        $participantId,
        $_POST['formation_id'],
        date("Y-m-d")
    ]);

    // 3. Préparer un message de confirmation
    $message = "✅ Inscription réussie pour {$_POST['prenom']} {$_POST['nom']}";
}
?>

<!-- ===== Partie HTML (formulaire) ===== -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription à une formation</title>
</head>
<body>
    <h2>Inscription à une formation</h2>

    <?php if ($message): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nom :</label>
        <input type="text" name="nom" required><br><br>

        <label>Prénom :</label>
        <input type="text" name="prenom" required><br><br>

        <label>Email :</label>
        <input type="email" name="email" required><br><br>

        <label>Téléphone :</label>
        <input type="text" name="telephone" required><br><br>

        <label>Formation :</label>
        <select name="formation_id" required>
            <option value="">-- Choisir une formation --</option>
            <?php foreach ($formations as $formation): ?>
                <option value="<?= $formation['id'] ?>">
                    <?= htmlspecialchars($formation['titre']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
