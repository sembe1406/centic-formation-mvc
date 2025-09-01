<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Paiement;

class PaiementController extends Controller
{
    private $paiementModel;

    public function __construct()
    {
        $this->paiementModel = new Paiement();
    }

    public function index()
    {
        $paiements = $this->paiementModel->getAll();
        return $this->view('paiements/list', ['paiements' => $paiements]);
    }

    public function store()
    {
        if (!$this->isMethod('POST')) {
            return $this->view('paiements/form');
        }

        $data = [
            'participant_id' => $this->input('participant_id'),
            'formation_id' => $this->input('formation_id'),
            'montant' => $this->input('montant'),
            'tranche' => $this->input('tranche'),
            'mode_paiement' => $this->input('mode_paiement')
        ];

        $this->paiementModel->create($data);
        return $this->redirect('/paiements');
    }
}