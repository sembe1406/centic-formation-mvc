<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Formation;

class FormationController extends Controller
{
    private $formationModel;

    public function __construct()
    {
        $this->formationModel = new Formation();
    }

    public function index()
    {
        $formations = $this->formationModel->getAll();
        return $this->view('formations/formation', ['formations' => $formations]);
    }

    public function show($id)
    {
        $formation = $this->formationModel->getById($id);
        if (!$formation) {
            return $this->redirect('/formations');
        }
        return $this->json($formation);
    }

    public function store()
    {
        if (!$this->isMethod('POST')) {
            return $this->redirect('/formations');
        }

        $data = [
            'titre' => $this->input('titre'),
            'description' => $this->input('description'),
            'date_debut' => $this->input('date_debut'),
            'date_fin' => $this->input('date_fin'),
            'prix' => $this->input('prix')
        ];

        $id = $this->formationModel->create($data);
        return $this->json(['success' => true, 'id' => $id]);
    }

    public function update($id)
    {
        if (!$this->isMethod('POST')) {
            return $this->redirect('/formations');
        }

        $data = [
            'titre' => $this->input('titre'),
            'description' => $this->input('description'),
            'date_debut' => $this->input('date_debut'),
            'date_fin' => $this->input('date_fin'),
            'prix' => $this->input('prix')
        ];

        $success = $this->formationModel->update($id, $data);
        return $this->json(['success' => $success]);
    }

    public function delete($id)
    {
        if (!$this->isMethod('POST')) {
            return $this->redirect('/formations');
        }

        $success = $this->formationModel->delete($id);
        return $this->json(['success' => $success]);
    }
}