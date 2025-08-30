<?php $title = 'Tableau de bord'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body p-4">
                    <h1 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Tableau de bord</h1>
                    <p class="lead mt-2 mb-0">Bienvenue, <?= htmlspecialchars($_SESSION['user']['username']) ?> !</p>
                </div>
            </div>
        </div>
    </div>

    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <!-- Dashboard pour les administrateurs -->
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h5 class="card-title">Formations</h5>
                        <p class="card-text">Gérer toutes les formations proposées</p>
                        <a href="/formations" class="btn btn-primary">Voir les formations</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h5 class="card-title">Formateurs</h5>
                        <p class="card-text">Gérer les formateurs et leurs spécialités</p>
                        <a href="/formateurs" class="btn btn-primary">Voir les formateurs</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="card-title">Participants</h5>
                        <p class="card-text">Gérer tous les participants inscrits</p>
                        <a href="/participants" class="btn btn-primary">Voir les participants</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h5 class="card-title">Paiements</h5>
                        <p class="card-text">Suivi des paiements et des factures</p>
                        <a href="/paiements" class="btn btn-primary">Voir les paiements</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Inscriptions récentes</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($recentInscriptions) && !empty($recentInscriptions)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Participant</th>
                                            <th>Formation</th>
                                            <th>Date</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentInscriptions as $inscription): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($inscription['participant_nom']) ?></td>
                                                <td><?= htmlspecialchars($inscription['formation_titre']) ?></td>
                                                <td><?= date('d/m/Y', strtotime($inscription['date_inscription'])) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $inscription['statut'] === 'en cours' ? 'primary' : ($inscription['statut'] === 'terminé' ? 'success' : 'danger') ?>">
                                                        <?= htmlspecialchars($inscription['statut']) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-3">
                                <a href="/inscriptions" class="btn btn-sm btn-outline-primary">Voir toutes les inscriptions</a>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">Aucune inscription récente.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Formations à venir</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($upcomingFormations) && !empty($upcomingFormations)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Date de début</th>
                                            <th>Formateur</th>
                                            <th>Inscrits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($upcomingFormations as $formation): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($formation['titre']) ?></td>
                                                <td><?= date('d/m/Y', strtotime($formation['date_debut'])) ?></td>
                                                <td><?= htmlspecialchars($formation['formateur_nom'] ?? 'Non assigné') ?></td>
                                                <td><?= $formation['nb_inscrits'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-3">
                                <a href="/formations" class="btn btn-sm btn-outline-primary">Voir toutes les formations</a>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">Aucune formation à venir.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($_SESSION['user']['role'] === 'formateur'): ?>
        <!-- Dashboard pour les formateurs -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h5 class="card-title">Mes formations</h5>
                        <p class="card-text">Formations que vous dispensez</p>
                        <a href="/formateur/formations" class="btn btn-primary">Voir mes formations</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h5 class="card-title">Mes séances</h5>
                        <p class="card-text">Planification des séances de formation</p>
                        <a href="/seances" class="btn btn-primary">Voir mes séances</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h5 class="card-title">Présences</h5>
                        <p class="card-text">Gérer les présences des participants</p>
                        <a href="/presences" class="btn btn-primary">Gérer les présences</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-calendar-day me-2"></i>Séances à venir</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($upcomingSeances) && !empty($upcomingSeances)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Formation</th>
                                            <th>Date</th>
                                            <th>Thème</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($upcomingSeances as $seance): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($seance['formation_titre']) ?></td>
                                                <td><?= date('d/m/Y', strtotime($seance['date_session'])) ?></td>
                                                <td><?= htmlspecialchars($seance['theme']) ?></td>
                                                <td>
                                                    <a href="/presences/seance/<?= $seance['id_seance'] ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-clipboard-check me-1"></i> Présences
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">Aucune séance à venir.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Dashboard pour les participants -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <h5 class="card-title">Mes formations</h5>
                        <p class="card-text">Formations auxquelles vous êtes inscrit</p>
                        <a href="/mes-formations" class="btn btn-primary">Voir mes formations</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <h5 class="card-title">Mes paiements</h5>
                        <p class="card-text">Historique de vos paiements</p>
                        <a href="/mes-paiements" class="btn btn-primary">Voir mes paiements</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Mes prochaines séances</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($participantSeances) && !empty($participantSeances)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Formation</th>
                                            <th>Date</th>
                                            <th>Thème</th>
                                            <th>Formateur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($participantSeances as $seance): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($seance['formation_titre']) ?></td>
                                                <td><?= date('d/m/Y', strtotime($seance['date_session'])) ?></td>
                                                <td><?= htmlspecialchars($seance['theme']) ?></td>
                                                <td><?= htmlspecialchars($seance['formateur_nom']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">Aucune séance à venir.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
