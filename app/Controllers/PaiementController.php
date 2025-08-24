<?php
require_once 'models/Paiement.php';

class PaiementController {
    private $paiement;

    public function __construct($db) {
        $this->paiement = new Paiement($db);
    }

    public function afficherFormulaire() {
        include 'views/paiement_form.php';
    }

    public function enregistrerPaiement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_inscription = $_POST['id_inscription'];
            $montant = $_POST['montant'];
            $mode = $_POST['mode'];
            $type_paiement = $_POST['type_paiement'];
            $date_paiement = $_POST['date_paiement'];

            $this->paiement->ajouterPaiement($id_inscription, $montant, $mode, $type_paiement, $date_paiement);
            header('Location: index.php?action=listerPaiements');
        }
    }

    public function listerPaiements() {
        $paiements = $this->paiement->getAllPaiements();
        include 'views/paiement_list.php';
    }
}
