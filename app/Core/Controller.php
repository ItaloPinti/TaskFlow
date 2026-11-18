<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = __DIR__ . '/../../views/' . $view . '.php';
        if (!is_file($viewFile)) {
            http_response_code(404);
            exit('Página não encontrada.');
        }
        require __DIR__ . '/../../views/layouts/header.php';
        require $viewFile;
        require __DIR__ . '/../../views/layouts/footer.php';
    }

    protected function redirect(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }

    protected function requireAuth(): int
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        return (int) $_SESSION['user_id'];
    }

    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf(): void
    {
        $token = $_POST['_token'] ?? '';
        if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(419);
            exit('Sessão expirada ou formulário inválido. Volte e tente novamente.');
        }
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}
