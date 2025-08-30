<?php
// Afficher toutes les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fonction d'autoload personnalisée
spl_autoload_register(function($class) {
    $prefix = '';
    $base_dir = __DIR__ . '/../';

    // Si la classe commence par "App\Core\"
    if (strpos($class, 'App\\Core\\') === 0) {
        $relative_class = substr($class, strlen('App\\Core\\'));
        $file = $base_dir . 'app/Core/' . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    } 
    // Si la classe commence par "App\Controllers\"
    elseif (strpos($class, 'App\\Controllers\\') === 0) {
        $relative_class = substr($class, strlen('App\\Controllers\\'));
        $file = $base_dir . 'app/Controllers/' . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    // Autres namespaces
    elseif (strpos($class, 'App\\') === 0) {
        $prefix = 'App\\';
        $base_dir .= 'app/';
    } elseif (strpos($class, 'Core\\') === 0) {
        $prefix = 'Core\\';
        $base_dir .= 'core/';
    }

    if ($prefix) {
        $relative_class = substr($class, strlen($prefix));
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }

    return false;
});

// Démarrer la session
session_start();

// Charger la configuration
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

// Créer le routeur
$router = new \App\Core\Router();

// Charger les routes
require_once __DIR__ . '/../config/routes.php';

// ✅ Récupérer et normaliser l'URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Supprimer /index.php si présent
if (strpos($uri, '/index.php') === 0) {
    $uri = substr($uri, strlen('/index.php'));
}

// Calculer le basePath (dossier public)
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$basePath   = rtrim(dirname($scriptName), '/');

// Supprimer le basePath si présent au début de l'URI
if ($basePath !== '' && $basePath !== '/' && strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Normalisation
$uri = '/' . ltrim($uri, '/');
$uri = rtrim($uri, '/');
if ($uri === '') {
    $uri = '/';
}

// DEBUG TEMPORAIRE (à commenter après)
# echo "<!-- METHOD={$method} URI={$uri} BASEPATH={$basePath} -->\n";

// Router la requête
try {
    echo $router->route($uri, $method);
} catch (\Throwable $e) {
    echo "<h1>Erreur</h1>";
    echo "<pre>";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString();
    echo "</pre>";
}
