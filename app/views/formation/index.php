<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formations</title>
</head>
<body>
    <h1>Liste des formations</h1>

    <h2>Dernières formations</h2>
    <ul>
        <?php foreach ($latest as $f): ?>
            <li>
                <?= htmlspecialchars($f['titre']) ?> - <?= htmlspecialchars($f['date_debut']) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Formations à venir</h2>
    <ul>
        <?php foreach ($upcoming as $f): ?>
            <li>
                <?= htmlspecialchars($f['titre']) ?> - <?= htmlspecialchars($f['date_debut']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>