<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\UserRepository;

final class AuthController extends Controller
{
    public function login(): void
    {
        if (!empty($_SESSION['user_id'])) $this->redirect('/dashboard');
        $this->view('auth/login', ['token' => $this->csrfToken()]);
    }

    public function authenticate(): void
    {
        $this->verifyCsrf();
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $user = $email ? (new UserRepository())->findByEmail($email) : null;

        if (!$user || !password_verify($password, $user['password'])) {
            $this->flash('error', 'E-mail ou senha inválidos.');
            $this->redirect('/login');
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $this->redirect('/dashboard');
    }

    public function register(): void
    {
        if (!empty($_SESSION['user_id'])) $this->redirect('/dashboard');
        $this->view('auth/register', ['token' => $this->csrfToken()]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $name = trim($_POST['name'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (mb_strlen($name) < 2 || !$email || strlen($password) < 8) {
            $this->flash('error', 'Informe um nome válido, e-mail válido e senha com pelo menos 8 caracteres.');
            $this->redirect('/register');
        }

        $users = new UserRepository();
        if ($users->findByEmail($email)) {
            $this->flash('error', 'Este e-mail já está cadastrado.');
            $this->redirect('/register');
        }

        $id = $users->create($name, $email, password_hash($password, PASSWORD_BCRYPT));
        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $this->redirect('/dashboard');
    }

    public function logout(): void
    {
        $this->verifyCsrf();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: /login');
        exit;
    }
}
