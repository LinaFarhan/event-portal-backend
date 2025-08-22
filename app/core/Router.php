<?php
// app/core/Router.php
namespace App\Core;

use App\Core\Response;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable|array $handler): void {
        $this->routes[] = [
            'method'  => strtoupper($method),
            'pattern' => $this->toRegex($path),
            'handler' => $handler,
        ];
    }

    public function run(): void {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // CORS preflight
        if ($method === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        foreach ($this->routes as $r) {
            if ($r['method'] === $method && preg_match($r['pattern'], $uri, $m)) {
                array_shift($m);
                $h = $r['handler'];
                if (is_array($h)) {
                    [$class, $fn] = $h;
                    $instance = new $class();
                    $instance->$fn(...$m);
                } else {
                    $h(...$m);
                }
                return;
            }
        }
        Response::json(['success'=>false,'message'=>'Route not found'], 404);
    }

    private function toRegex(string $path): string {
        // يدعم {id} و {slug}
        $regex = preg_replace('#\{[\w]+\}#', '([\w-]+)', rtrim($path,'/'));
        return '#^' . ($regex === '' ? '/' : $regex) . '$#';
    }
}