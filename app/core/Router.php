<?php
namespace App\Core;

class Router
{
    private $routes = [];
    private $notFoundCallback;
    
    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }
    
    public function set404($callback)
    {
        $this->notFoundCallback = $callback;
    }
    
    public function dispatch()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        
        foreach ($this->routes as $route) {
            $pattern = $this->buildPattern($route['path']);
            
            if ($requestMethod === $route['method'] && preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);
                
                if (is_callable($route['handler'])) {
                    return call_user_func_array($route['handler'], $matches);
                }
                
                if (is_array($route['handler'])) {
                    list($controller, $method) = $route['handler'];
                    return call_user_func_array([$controller, $method], $matches);
                }
            }
        }
        
    
        if ($this->notFoundCallback) {
            call_user_func($this->notFoundCallback);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
    
    private function buildPattern($path)
    {
        return '#^' . preg_replace('/\(\\\\d\+\)/', '(\d+)', $path) . '$#';
    }
}