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
            'method' => strtoupper($method),
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

    public function notFound($callback)
    {
        $this->notFoundCallback = $callback;
    }

    public function route($uri, $method)
    {
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            $pattern = $this->convertUriToRegex($route['uri']);

            if (preg_match($pattern, $uri, $matches)) {
                if ($route['method'] === $method) {
                    array_shift($matches); // Supprimer la correspondance complète

                    [$controllerName, $action] = explode('@', $route['controller']);
                    $controllerName = "App\\Controllers\\{$controllerName}";

                    if (!class_exists($controllerName)) {
                        return $this->defaultNotFound();
                    }

                    $controller = new $controllerName();

                    if (!method_exists($controller, $action)) {
                        return $this->defaultNotFound();
                    }

                    return call_user_func_array([$controller, $action], $matches);
                }
            }
        }

        // Si aucune route ne correspond
        if ($this->notFoundCallback) {
            return call_user_func($this->notFoundCallback);
        }

        return $this->defaultNotFound();
    }

    private function convertUriToRegex($uri)
    {
        // Convertir {param} en ([^/]+)
        $regex = preg_replace('/\{(\w+)\}/', '([^/]+)', $uri);
        return "@^$regex$@";
    }

    private function defaultNotFound()
    {
        http_response_code(404);
        return "404 - Page non trouvée";
    }
}
