<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Formation;

class HomeController extends Controller
{
    private $formationModel;
    
    public function __construct()
    {
        $this->formationModel = new Formation();
    }
    
    public function index()
    {
        // Récupérer les 3 dernières formations
        $formations = []; // Temporairement vide, à remplacer par $this->formationModel->getLatest(3);
        
        return $this->view('home', [
            'formations' => $formations
        ]);
    }
    
    public function dashboard()
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour accéder au tableau de bord.";
            $this->redirect('/login');
        }
        
        // Logique du tableau de bord selon le rôle de l'utilisateur
        $role = $_SESSION['user']['role'];
        
        if ($role === 'admin') {
            return $this->view('dashboard/admin');
        } elseif ($role === 'formateur') {
            return $this->view('dashboard/formateur');
        } else {
            return $this->view('dashboard/participant');
        }
    }
}
