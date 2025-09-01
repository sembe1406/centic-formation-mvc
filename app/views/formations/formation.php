<?php $title = 'Formations'; ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Centic Formation</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="/formations">Formations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/formateurs">Formateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dispensations">Dispensations</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Liste des formations</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formationModal">
                Nouvelle formation
            </button>
        </div>

        <!-- Table des formations -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($formations as $formation): ?>
                    <tr>
                        <td><?= htmlspecialchars($formation->titre) ?></td>
                        <td><?= htmlspecialchars($formation->date_debut) ?></td>
                        <td><?= htmlspecialchars($formation->date_fin) ?></td>
                        <td><?= number_format($formation->prix, 2) ?> €</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="showFormation(<?= $formation->id_formation ?>)">
                                Afficher
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="editFormation(<?= $formation->id_formation ?>)">
                                Modifier
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteFormation(<?= $formation->id_formation ?>)">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal pour créer/modifier une formation -->
    <div class="modal fade" id="formationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Formation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formationForm">
                        <input type="hidden" id="formation_id">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                        </div>
                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                        </div>
                        <div class="mb-3">
                            <label for="prix" class="form-label">Prix</label>
                            <input type="number" class="form-control" id="prix" name="prix" step="0.01" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="saveFormation()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fonctions JavaScript pour gérer les actions CRUD
        function showFormation(id) {
            fetch(`/formations/${id}`)
                .then(response => response.json())
                .then(formation => {
                    document.getElementById('formation_id').value = formation.id_formation;
                    document.getElementById('titre').value = formation.titre;
                    document.getElementById('description').value = formation.description;
                    document.getElementById('date_debut').value = formation.date_debut;
                    document.getElementById('date_fin').value = formation.date_fin;
                    document.getElementById('prix').value = formation.prix;
                    
                    const modal = new bootstrap.Modal(document.getElementById('formationModal'));
                    modal.show();
                });
        }

        function editFormation(id) {
            showFormation(id);
        }

        function deleteFormation(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette formation ?')) {
                fetch(`/formations/${id}/delete`, {
                    method: 'POST',
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        location.reload();
                    }
                });
            }
        }

        function saveFormation() {
            const formData = new FormData(document.getElementById('formationForm'));
            const id = document.getElementById('formation_id').value;
            
            fetch(id ? `/formations/${id}` : '/formations', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    location.reload();
                }
            });
        }
    </script>
