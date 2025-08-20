<?php
namespace App\Middleware;

use App\Models\User;

class Auth
{
    /**
     * Vérifier si l'utilisateur est connecté
     * 
     * @return bool True si l'utilisateur est connecté
     */
    public static function check()
    {
        return isset($_SESSION['user']);
    }
    
    /**
     * Vérifier si l'utilisateur a un rôle spécifique
     * 
     * @param string|array $roles Rôle(s) à vérifier
     * @return bool True si l'utilisateur a le rôle spécifié
     */
    public static function hasRole($roles)
    {
        if (!self::check()) {
            return false;
        }
        
        $userRole = $_SESSION['user']['role'];
        
        if (is_array($roles)) {
            return in_array($userRole, $roles);
        }
        
        return $userRole === $roles;
    }
    
    /**
     * Récupérer l'ID de l'utilisateur connecté
     * 
     * @return int|null ID de l'utilisateur ou null si non connecté
     */
    public static function id()
    {
        return self::check() ? $_SESSION['user']['id'] : null;
    }
    
    /**
     * Récupérer l'utilisateur connecté
     * 
     * @return array|null Données de l'utilisateur ou null si non connecté
     */
    public static function user()
    {
        if (!self::check()) {
            return null;
        }
        
        $userModel = new User();
        return $userModel->findById(self::id());
    }
    
    /**
     * Vérifier si l'utilisateur est administrateur
     * 
     * @return bool True si l'utilisateur est administrateur
     */
    public static function isAdmin()
    {
        return self::hasRole('admin');
    }
    
    /**
     * Vérifier si l'utilisateur est formateur
     * 
     * @return bool True si l'utilisateur est formateur
     */
    public static function isFormateur()
    {
        return self::hasRole('formateur');
    }
    
    /**
     * Vérifier si l'utilisateur est participant
     * 
     * @return bool True si l'utilisateur est participant
     */
    public static function isParticipant()
    {
        return self::hasRole('participant');
    }
    
    /**
     * Rediriger si l'utilisateur n'est pas connecté
     * 
     * @param string $redirect URL de redirection si non connecté
     * @return void
     */
    public static function redirectIfNotLoggedIn($redirect = '/login')
    {
        if (!self::check()) {
            header("Location: {$redirect}");
            exit;
        }
    }
    
    /**
     * Rediriger si l'utilisateur n'a pas le rôle spécifié
     * 
     * @param string|array $roles Rôle(s) autorisé(s)
     * @param string $redirect URL de redirection si non autorisé
     * @return void
     */
    public static function redirectIfNotRole($roles, $redirect = '/')
    {
        if (!self::hasRole($roles)) {
            header("Location: {$redirect}");
            exit;
        }
    }
}
