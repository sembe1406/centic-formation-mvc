<?php $title = 'Accueil'; ?>

<div class="jumbotron">
    <h1 class="display-4">Centic Formation Management Platform</h1>
    <p class="lead">Votre plateforme de gestion des formations professionnelles.</p>
    <hr class="my-4">
    <p>Découvrez nos formations, inscrivez-vous et suivez votre progression en temps réel.</p>
    
</div>


</div>


<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-graduation-cap"></i> Formations de qualité</h5>
                <p class="card-text">Accédez à des formations professionnelles de qualité dispensées par des experts du domaine.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Formateurs expérimentés</h5>
                <p class="card-text">Nos formateurs sont des professionnels expérimentés qui partagent leur expertise avec passion.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-chart-line"></i> Suivi personnalisé</h5>
                <p class="card-text">Bénéficiez d'un suivi personnalisé tout au long de votre parcours de formation.</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h2 class="text-center mb-4">Nos dernières formations</h2>
    
    <?php if (isset($formations) && !empty($formations)): ?>
        <div class="row">
            <?php foreach ($formations as $formation): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($formation['titre']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($formation['description'], 0, 100)) ?>...</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Du <?= date('d/m/Y', strtotime($formation['date_debut'])) ?> 
                                    au <?= date('d/m/Y', strtotime($formation['date_fin'])) ?>
                                </small>
                            </p>
                            <a href="/formations/<?= $formation['id_formation'] ?>" class="btn btn-outline-primary">Voir plus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Aucune formation disponible pour le moment.
        </div>
    <?php endif; ?>
</div>