<?php
namespace Core;

class View
{
    public static function render($view, $data = [])
    {
        extract($data);
        
        $viewPath = __DIR__ . "/../app/views/{$view}.php";
        
        if (!file_exists($viewPath)) {
            throw new \Exception("La vue {$view} n'existe pas");
        }
        
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        
        return $content;
    }
    
    public static function renderWithLayout($view, $layout = 'main', $data = [])
    {
        $content = self::render($view, $data);
        
        $layoutPath = __DIR__ . "/../app/views/layouts/{$layout}.php";
        
        if (!file_exists($layoutPath)) {
            throw new \Exception("Le layout {$layout} n'existe pas");
        }
        
        ob_start();
        require $layoutPath;
        $finalContent = ob_get_clean();
        
        return $finalContent;
    }
}
