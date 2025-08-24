<form method="POST" action="index.php?action=enregistrerPaiement">
    <label for="id_inscription">Inscription :</label>
    <select name="id_inscription" required>
        <!-- À remplir dynamiquement avec les inscriptions -->
        <option value="1">Participant 1 - Formation A</option>
        <option value="2">Participant 2 - Formation B</option>
    </select>

    <label for="type_paiement">Type :</label>
    <select name="type_paiement" required>
        <option value="INSCRIPTION">Inscription</option>
        <option value="TRANCHE">Tranche</option>
    </select>

    <label for="montant">Montant :</label>
    <input type="number" name="montant" required>

    <label for="mode">Mode :</label>
    <select name="mode" required>
        <option value="espèces">Espèces</option>
        <option value="mobile money">Mobile Money</option>
        <option value="virement">Virement</option>
    </select>

    <label for="date_paiement">Date :</label>
    <input type="date" name="date_paiement" value="<?= date('Y-m-d') ?>" required>

    <button type="submit">Enregistrer</button>
</form>
