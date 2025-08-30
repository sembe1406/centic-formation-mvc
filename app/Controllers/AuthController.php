<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new User();
    }
    
    /**
     * Afficher le formulaire de connexion
     */
    public function loginView()
    {
        // Si l'utilisateur est déjà connecté, rediriger vers le tableau de bord
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        // Générer un token CSRF
        $this->generateCSRFToken();
        
        $user = []; // Temporairement vide, à remplacer par $this->formationModel->getLatest(3);
        
        return $this->view('login', [
            'user' => $user
        ]);
    }
    
    /**
     * Traiter la soumission du formulaire de connexion
     */
    public function login()
    {
        // Vérifier si la requête est en POST
        if (!$this->isMethod('POST')) {
            $this->redirect('/login');
        }
        
        // Valider le CSRF token
        $this->validateCSRF();
        
        // Récupérer les données du formulaire
        $username = $this->input('username');
        $password = $this->input('password');
        
        // Valider les données
        $errors = [];
        
        if (empty($username)) {
            $errors['username'] = "Le nom d'utilisateur est requis";
        }
        
        if (empty($password)) {
            $errors['password'] = "Le mot de passe est requis";
        }
        
        // S'il y a des erreurs, rediriger vers le formulaire avec les erreurs
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['username' => $username];
            $this->redirect('/login');
        }
        
        // Rechercher l'utilisateur
        $user = $this->userModel->findByUsername($username);
        
        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if (!$user || !password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['errors'] = ['auth' => "Nom d'utilisateur ou mot de passe incorrect"];
            $_SESSION['old'] = ['username' => $username];
            $this->redirect('/login');
        }
        
        // Vérifier si l'utilisateur est actif
        if (!$user['est_actif']) {
            $_SESSION['errors'] = ['auth' => "Votre compte est désactivé. Veuillez contacter l'administrateur."];
            $this->redirect('/login');
        }
        
        // Mettre à jour la dernière connexion
        $this->userModel->updateLastLogin($user['id_utilisateur']);
        
        // Créer la session utilisateur
        $_SESSION['user'] = [
            'id' => $user['id_utilisateur'],
            'username' => $user['nom_utilisateur'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        
        // Rediriger vers le tableau de bord
        $this->redirect('/dashboard');
    }
    
    /**
     * Afficher le formulaire d'inscription
     */
    public function registerView()
    {
        // Si l'utilisateur est déjà connecté, rediriger vers le tableau de bord
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        // Générer un token CSRF
        $this->generateCSRFToken();
        
        return $this->view('register');

        
    }
    
    /**
     * Traiter la soumission du formulaire d'inscription
     */
    public function register()
    {
        // Vérifier si la requête est en POST
        if (!$this->isMethod('POST')) {
            $this->redirect('/register');
        }
        
        // Valider le CSRF token
        $this->validateCSRF();
        
        // Récupérer les données du formulaire
        $username = $this->input('username');
        $email = $this->input('email');
        $password = $this->input('password');
        $passwordConfirm = $this->input('password_confirm');
        
        // Valider les données
        $errors = [];
        
        if (empty($username)) {
            $errors['username'] = "Le nom d'utilisateur est requis";
        } elseif (strlen($username) < 3 || strlen($username) > 50) {
            $errors['username'] = "Le nom d'utilisateur doit contenir entre 3 et 50 caractères";
        } elseif ($this->userModel->findByUsername($username)) {
            $errors['username'] = "Ce nom d'utilisateur est déjà utilisé";
        }
        
        if (empty($email)) {
            $errors['email'] = "L'email est requis";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'email est invalide";
        } elseif ($this->userModel->findByEmail($email)) {
            $errors['email'] = "Cet email est déjà utilisé";
        }
        
        if (empty($password)) {
            $errors['password'] = "Le mot de passe est requis";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Le mot de passe doit contenir au moins 6 caractères";
        }
        
        if ($password !== $passwordConfirm) {
            $errors['password_confirm'] = "Les mots de passe ne correspondent pas";
        }
        
        // S'il y a des erreurs, rediriger vers le formulaire avec les erreurs
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = [
                'username' => $username,
                'email' => $email
            ];
            $this->redirect('/register');
        }
        
        // Créer l'utilisateur
        $userId = $this->userModel->create([
            'nom_utilisateur' => $username,
            'email' => $email,
            'mot_de_passe' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'participant', // Par défaut, les nouveaux utilisateurs sont des participants
            'est_actif' => true
        ]);
        
        // Message de succès
        $_SESSION['success'] = "Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.";
        
        // Rediriger vers la page de connexion
        $this->redirect('/login');
    }
    
    /**
     * Déconnecter l'utilisateur
     */
    public function logout()
    {
        // Supprimer la session utilisateur
        unset($_SESSION['user']);
        
        // Rediriger vers la page d'accueil
        $this->redirect('/');
    }
    
    /**
     * Vérifier si l'utilisateur est connecté
     * 
     * @return bool True si l'utilisateur est connecté
     */
    private function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }
}
