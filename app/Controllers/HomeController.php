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
        
        // Données communes pour tous les rôles
        $data = [];
        
        // Logique du tableau de bord selon le rôle de l'utilisateur
        $role = $_SESSION['user']['role'];
        
        if ($role === 'admin') {
            // Récupérer les données pour l'administrateur
            // Dans une version réelle, ces données viendraient de la base de données
            $data['recentInscriptions'] = []; // À remplacer par des données réelles
            $data['upcomingFormations'] = []; // À remplacer par des données réelles
        } elseif ($role === 'formateur') {
            // Récupérer les données pour le formateur
            $data['upcomingSeances'] = []; // À remplacer par des données réelles
        } else {
            // Récupérer les données pour le participant
            $data['participantSeances'] = []; // À remplacer par des données réelles
        }
        
        return $this->view('dashboard', $data);
    }
}
