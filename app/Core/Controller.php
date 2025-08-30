<?php
namespace App\Core;

class Controller
{
    protected function view($name, $data = [])
    {
        extract($data);
        
        // Vérifier si le fichier de vue existe directement
        $viewPath = __DIR__ . "/../views/{$name}.php";
        
        // Essayons aussi le chemin avec les sous-dossiers (si nécessaire)
        if (!file_exists($viewPath) && strpos($name, '/') === false) {
            $folders = ['auth', 'admin', 'user']; // Dossiers potentiels à vérifier
            
            foreach ($folders as $folder) {
                $altPath = __DIR__ . "/../views/{$folder}/{$name}.php";
                if (file_exists($altPath)) {
                    $viewPath = $altPath;
                    break;
                }
            }
        }
        
        echo "<!-- Looking for view at: {$viewPath} -->\n";
        error_log("Looking for view at: {$viewPath}");
        
        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            
            // Vérifier si le layout existe
            $layoutPath = __DIR__ . "/../views/layouts/main.php";
            if (file_exists($layoutPath)) {
                require $layoutPath;
            } else {
                echo $content;
            }
        } else {
            echo "Vue {$name} non trouvée au chemin {$viewPath}";
            error_log("View not found: {$viewPath}");
            
            // Lister toutes les vues disponibles
            $views = glob(__DIR__ . "/../views/*.php");
            $viewsInFolders = glob(__DIR__ . "/../views/*/*.php");
            $allViews = array_merge($views, $viewsInFolders);
            
            echo "<p>Vues disponibles:</p><ul>";
            foreach ($allViews as $view) {
                echo "<li>" . basename(dirname($view)) . "/" . basename($view) . "</li>";
            }
            echo "</ul>";
        }
    }

    protected function json($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function input($key = null, $default = null)
    {
        $data = array_merge($_GET, $_POST);
        
        if ($key === null) {
            return $data;
        }
        
        return $data[$key] ?? $default;
    }

    protected function isMethod($method)
    {
        return $_SERVER['REQUEST_METHOD'] === strtoupper($method);
    }

    protected function validateCSRF()
    {
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = 'Erreur de sécurité : CSRF token invalide. Veuillez réessayer.';
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }
    }
    
    protected function generateCSRFToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}