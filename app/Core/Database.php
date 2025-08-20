<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;
    private $statement;

    private function __construct()
    {
        try {
            // Chemin absolu vers le fichier de configuration
            $configPath = realpath(__DIR__ . '/../../config/config.php');
            
            // Vérifier si le fichier existe
            if (!$configPath || !file_exists($configPath)) {
                $testPath = __DIR__ . '/../../config/config.php';
                throw new \Exception("Le fichier de configuration n'existe pas à: " . $testPath);
            }
            
            // Charger la configuration
            $config = include $configPath;
            
            // Vérifier si la configuration est correctement chargée
            if (!is_array($config)) {
                throw new \Exception("La configuration n'est pas un tableau valide");
            }
            
            if (!isset($config['database'])) {
                throw new \Exception("La clé 'database' est manquante dans la configuration");
            }
            
            $db = $config['database'];
            
            // Vérifier les clés obligatoires
            $requiredKeys = ['host', 'name', 'user'];
            foreach ($requiredKeys as $key) {
                if (!isset($db[$key])) {
                    throw new \Exception("La clé '{$key}' est manquante dans la configuration de la base de données");
                }
            }
            
            // Utiliser utf8 au lieu de utf8mb4 car certaines versions de MySQL ne supportent pas utf8mb4
            $charset = isset($db['charset']) ? $db['charset'] : 'utf8';
            
            // Simplifier le DSN pour éviter les problèmes avec le jeu de caractères
            $dsn = "mysql:host={$db['host']};dbname={$db['name']}";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, $db['user'], $db['password'] ?? '', $options);
            
            // Définir le jeu de caractères après la connexion
            $this->connection->exec("SET NAMES {$charset}");
        } catch (\Exception $e) {
            die("Erreur de configuration: " . $e->getMessage());
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query($sql, $params = [])
    {
        $this->statement = $this->connection->prepare($sql);
        $this->statement->execute($params);
        return $this;
    }

    public function findAll()
    {
        return $this->statement->fetchAll();
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}