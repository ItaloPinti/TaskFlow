<?php
declare(strict_types=1);

session_start();

define('BASE_PATH', dirname(__DIR__));

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) return;
    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $file = BASE_PATH . '/app/' . $relative . '.php';
    if (is_file($file)) require $file;
});

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\TaskController;
use App\Controllers\CategoryController;

$router = new Router();

$router->get('/', [DashboardController::class, 'index']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'store']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/tasks', [TaskController::class, 'index']);
$router->get('/tasks/create', [TaskController::class, 'create']);
$router->post('/tasks/store', [TaskController::class, 'store']);
$router->get('/tasks/edit', [TaskController::class, 'edit']);
$router->post('/tasks/update', [TaskController::class, 'update']);
$router->post('/tasks/delete', [TaskController::class, 'delete']);

$router->get('/categories', [CategoryController::class, 'index']);
$router->post('/categories/store', [CategoryController::class, 'store']);
$router->post('/categories/delete', [CategoryController::class, 'delete']);

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Throwable $e) {
    error_log((string) $e);
    http_response_code(500);
    echo '<main style="font-family:Arial;padding:40px"><h1>Ops! Ocorreu um erro.</h1><p>Confira a conexão com o banco e os logs do PHP.</p></main>';
}
