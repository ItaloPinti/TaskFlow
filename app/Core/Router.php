<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $action): void { $this->routes['GET'][$path] = $action; }
    public function post(string $path, array $action): void { $this->routes['POST'][$path] = $action; }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $action = $this->routes[$method][$path] ?? null;

        if (!$action) {
            http_response_code(404);
            echo 'Página não encontrada. <a href="/">Voltar</a>';
            return;
        }

        [$controller, $methodName] = $action;
        (new $controller())->$methodName();
    }
}
