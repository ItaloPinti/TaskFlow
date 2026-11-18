<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\CategoryRepository;

final class CategoryController extends Controller
{
    public function index(): void
    {
        $userId = $this->requireAuth();
        $this->view('categories/index', [
            'categories' => (new CategoryRepository())->allByUser($userId),
            'token' => $this->csrfToken()
        ]);
    }

    public function store(): void
    {
        $userId = $this->requireAuth();
        $this->verifyCsrf();
        $name = trim($_POST['name'] ?? '');
        if ($name === '' || mb_strlen($name) > 60) {
            $this->flash('error', 'Informe uma categoria de até 60 caracteres.');
        } else {
            (new CategoryRepository())->create($userId, $name);
            $this->flash('success', 'Categoria criada.');
        }
        $this->redirect('/categories');
    }

    public function delete(): void
    {
        $userId = $this->requireAuth();
        $this->verifyCsrf();
        (new CategoryRepository())->delete((int) ($_POST['id'] ?? 0), $userId);
        $this->flash('success', 'Categoria excluída. As tarefas associadas ficaram sem categoria.');
        $this->redirect('/categories');
    }
}
