<?php
namespace App\Core;

class Router
{
    private $routes = [];
    private $notFoundCallback;

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
        ];

        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function notFound($controller)
    {
        $this->notFoundCallback = $controller;
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            // Conversion de l'URI en expression régulière
            $pattern = $this->convertUriToRegex($route['uri']);
            
            if (preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {
                // Extraire les paramètres de l'URI
                array_shift($matches); // Supprimer la correspondance complète
                
                // Séparer le contrôleur et la méthode
                [$controllerName, $method] = explode('@', $route['controller']);
                $controllerName = "App\\Controllers\\{$controllerName}";
                
                // Instancier le contrôleur et appeler la méthode
                $controller = new $controllerName();
                return call_user_func_array([$controller, $method], $matches);
            }
        }

        if ($this->notFoundCallback) {
            return call_user_func($this->notFoundCallback);
        }

        return $this->defaultNotFound();
    }

    private function convertUriToRegex($uri)
    {
        // Remplacer {param} par (\w+)
        $regex = preg_replace('/\{(\w+)\}/', '([^/]+)', $uri);
        return "@^$regex$@";
    }

    private function defaultNotFound()
    {
        http_response_code(404);
        return "404 Page Not Found";
    }
}