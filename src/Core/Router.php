<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    // Route registreren
    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method'  => strtoupper($method),
            'path'    => $path,
            'handler' => $handler,
        ];
    }

    // Hulpmethodes voor leesbaarheid
    public function get(string $path, callable $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    public function put(string $path, callable $handler): void
    {
        $this->add('PUT', $path, $handler);
    }

    public function delete(string $path, callable $handler): void
    {
        $this->add('DELETE', $path, $handler);
    }

    // Binnenkomende request matchen
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // /filmapi/public verwijderen uit het pad
        $path = preg_replace('#^/filmapi/public#', '', $path);
        $path = $path ?: '/';

        foreach ($this->routes as $route) {
            $pattern = $this->toRegex($route['path']);

            if ($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                // Gevonden parameters uit de URL halen (bv. {id})
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }

        // Geen route gevonden
        http_response_code(404);
        echo json_encode(['error' => 'Route niet gevonden']);
    }

    // /films/{id} omzetten naar een regex
    private function toRegex(string $path): string
    {
        $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
}