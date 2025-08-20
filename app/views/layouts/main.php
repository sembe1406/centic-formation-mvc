<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Centic Formation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="/">Centic Formation</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Accueil</a>
                        </li>
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboard">Tableau de bord</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/formations">Formations</a>
                            </li>
                            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown">
                                        Administration
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/formateurs">Formateurs</a>
                                        <a class="dropdown-item" href="/participants">Participants</a>
                                        <a class="dropdown-item" href="/inscriptions">Inscriptions</a>
                                        <a class="dropdown-item" href="/paiements">Paiements</a>
                                        <a class="dropdown-item" href="/rapports">Rapports</a>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['user']['role'] === 'formateur'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/seances">Mes séances</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/presences">Présences</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['user']['role'] === 'participant'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/mes-formations">Mes formations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/mes-paiements">Mes paiements</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                    <?= htmlspecialchars($_SESSION['user']['username']) ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/profile">Mon profil</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/logout">Déconnexion</a>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/register">Inscription</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <footer class="bg-light py-4 mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <?= date('Y') ?> Centic Formation. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <p>Développé par Centic</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/js/script.js"></script>
</body>
</html>
