<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>CFMP</title>
    <!-- Bootstrap local -->
    <link rel="stylesheet" href="/vendor/bootstrap/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Thème personnalisé avec les couleurs principales (bleu nuit, noir clair, blanc) -->
    <link rel="stylesheet" href="/css/theme.css">
    <!-- Styles spécifiques à l'application -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <i class="fas fa-graduation-cap me-2"></i>
                    CFMP
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/"><i class="fas fa-home me-1"></i> Accueil</a>
                        </li>
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboard"><i class="fas fa-tachometer-alt me-1"></i> Tableau de bord</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/formations"><i class="fas fa-chalkboard-teacher me-1"></i> Formations</a>
                            </li>
                            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-cogs me-1"></i> Administration
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/formateurs"><i class="fas fa-user-tie me-1"></i> Formateurs</a></li>
                                        <li><a class="dropdown-item" href="/participants"><i class="fas fa-users me-1"></i> Participants</a></li>
                                        <li><a class="dropdown-item" href="/inscriptions"><i class="fas fa-clipboard-list me-1"></i> Inscriptions</a></li>
                                        <li><a class="dropdown-item" href="/paiements"><i class="fas fa-money-bill-wave me-1"></i> Paiements</a></li>
                                        <li><a class="dropdown-item" href="/rapports"><i class="fas fa-chart-bar me-1"></i> Rapports</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['user']['role'] === 'formateur'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/seances"><i class="fas fa-calendar-alt me-1"></i> Mes séances</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/presences"><i class="fas fa-clipboard-check me-1"></i> Présences</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['user']['role'] === 'participant'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/mes-formations"><i class="fas fa-book-reader me-1"></i> Mes formations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/mes-paiements"><i class="fas fa-receipt me-1"></i> Mes paiements</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="/profile"><i class="fas fa-id-card me-1"></i> Mon profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-1"></i> Déconnexion</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt me-1"></i> Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/register"><i class="fas fa-user-plus me-1"></i> Inscription</a>
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
                <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5><i class="fas fa-graduation-cap me-2"></i> Centic Formation</h5>
                    <p>Votre plateforme de gestion des formations professionnelles.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5><i class="fas fa-map-marker-alt me-2"></i> Contactez-nous</h5>
                    <p><i class="fas fa-envelope me-2"></i> contact@centic-formation.com</p>
                    <p><i class="fas fa-phone me-2"></i> +00 123 456 789</p>
                </div>
                <div class="col-md-4">
                    <h5><i class="fas fa-link me-2"></i> Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-light"><i class="fas fa-angle-right me-2"></i> Accueil</a></li>
                        <li><a href="/formations" class="text-light"><i class="fas fa-angle-right me-2"></i> Formations</a></li>
                        <li><a href="/contact" class="text-light"><i class="fas fa-angle-right me-2"></i> Contact</a></li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> Centic Formation. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Développé par Centic</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS en local -->
    <script src="/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- Scripts personnalisés -->
    <script src="/js/script.js"></script>
</body>
</html>
