<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails formation</title>
</head>
<body>
    <h1>Détails de la formation</h1>

    <h2>Formateurs</h2>
    <ul>
        <?php foreach ($formateurs as $f): ?>
            <li><?= htmlspecialchars($f['nom']) ?> <?= htmlspecialchars($f['prenom']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Séances</h2>
    <ul>
        <?php foreach ($seances as $s): ?>
            <li><?= htmlspecialchars($s['date_session']) ?> - <?= htmlspecialchars($s['lieu']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Nombre de participants</h2>
    <p><?= $count ?></p>
</body>
</html>