<?php
// Afficher tous les messages d'erreur
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Chemin vers le fichier de configuration
$configPath = __DIR__ . '/../config/config.php';

// Vérifier si le fichier existe
echo "Vérification du fichier de configuration à: " . $configPath . "<br>";
echo "Le fichier existe: " . (file_exists($configPath) ? 'Oui' : 'Non') . "<br>";

// Essayer de charger la configuration
echo "Chargement de la configuration...<br>";
try {
    $config = require $configPath;
    echo "Configuration chargée avec succès.<br>";
    echo "Type de la configuration: " . gettype($config) . "<br>";
    
    if (is_array($config)) {
        echo "Clés dans la configuration: " . implode(', ', array_keys($config)) . "<br>";
        
        if (isset($config['database'])) {
            echo "Configuration de la base de données trouvée.<br>";
            echo "Hôte: " . $config['database']['host'] . "<br>";
            echo "Base de données: " . $config['database']['name'] . "<br>";
        } else {
            echo "Erreur: Clé 'database' non trouvée dans la configuration.<br>";
        }
    } else {
        echo "Erreur: La configuration n'est pas un tableau.<br>";
    }
} catch (Exception $e) {
    echo "Erreur lors du chargement de la configuration: " . $e->getMessage() . "<br>";
}
