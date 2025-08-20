<?php
// Fonction d'autoload personnalisée
spl_autoload_register(function($class) {
    // Conversion du namespace en chemin de fichier
    $prefix = '';
    $base_dir = __DIR__ . '/../';
    
    // Si la classe commence par "App\"
    if (strpos($class, 'App\\') === 0) {
        $prefix = 'App\\';
        $base_dir .= 'app/';
    } 
    // Si la classe commence par "Core\"
    elseif (strpos($class, 'Core\\') === 0) {
        $prefix = 'Core\\';
        $base_dir .= 'core/';
    }
    
    // Si le préfixe correspond
    if ($prefix) {
        // Obtenir le chemin relatif
        $relative_class = substr($class, strlen($prefix));
        
        // Convertir le namespace en chemin de fichier
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        
        // Si le fichier existe, le charger
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    return false;
});

// Démarrer la session
session_start();

// Chargement de la configuration
$config = require_once __DIR__ . '/../config/config.php';

// Définir l'environnement
$isDebug = $config['app']['debug'] ?? false;
if ($isDebug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Chargement des routes
require_once __DIR__ . '/../config/routes.php';

// Récupérer l'URI et la méthode de la requête
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Supprimer le préfixe du dossier public si nécessaire
$basePath = dirname($_SERVER['SCRIPT_NAME']);
if ($basePath !== '/') {
    $uri = substr($uri, strlen($basePath));
}

// Si l'URI est vide, définir sur '/'
if (empty($uri)) {
    $uri = '/';
}

// Router la requête
echo $router->route($uri, $method);
