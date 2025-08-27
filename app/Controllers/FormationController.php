<?php
namespace App\Controllers;

use App\Models\Formation;

class FormationController
{
    protected $formationModel;

    public function __construct()
    {
        $this->formationModel = new Formation();
    }

    // Afficher la liste des formations
    public function index()
    {
        $latest = $this->formationModel->getLatest(3);
        $upcoming = $this->formationModel->getUpcoming(3);

        // On passe les données à la vue
        require __DIR__ . "/../Views/formation/index.php";
    }

    // Afficher les détails d’une formation
    public function show($id)
    {
        $formateurs = $this->formationModel->getFormateurs($id);
        $seances = $this->formationModel->getSeances($id);
        $count = $this->formationModel->countParticipants($id);

        require __DIR__ . "/../Views/formation/show.php";
    }
}