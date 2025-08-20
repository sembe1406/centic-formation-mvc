<?php
namespace App\Core;

class Controller
{
    protected function view($name, $data = [])
    {
        extract($data);
        
        // Vérifier si le fichier de vue existe
        $viewPath = __DIR__ . "/../views/{$name}.php";
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
            echo "Vue {$name} non trouvée";
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
        if (!isset($_POST['_csrf']) || !isset($_SESSION['_csrf']) || $_POST['_csrf'] !== $_SESSION['_csrf']) {
            $this->json(['error' => 'CSRF token mismatch'], 403);
        }
    }
}