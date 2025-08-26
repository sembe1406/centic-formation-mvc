<?php include 'db.php'; ?>

<form action="ajouter_paiement.php" method="POST">
    <label>Participant :</label>
    <select name="participant_id" required>
        <?php
        $stmt = $pdo->query("SELECT id, nom FROM participants");
        while ($row = $stmt->fetch()) {
            echo "<option value='{$row['id']}'>{$row['nom']}</option>";
        }
        ?>
    </select><br>

    <label>Type :</label>
    <select name="type" required>
        <option value="inscription">Inscription</option>
        <option value="tranche">Tranche</option>
    </select><br>

    <label>Montant :</label>
    <input type="number" name="montant" min="0" required><br>

    <label>Date :</label>
    <input type="date" name="date" required><br>

    <button type="submit">Enregistrer</button>
</form>
