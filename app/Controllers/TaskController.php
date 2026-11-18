<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\TaskRepository;
use App\Repositories\CategoryRepository;

final class TaskController extends Controller
{
    public function index(): void
    {
        $userId = $this->requireAuth();
        $this->view('tasks/index', [
            'tasks' => (new TaskRepository())->allByUser($userId),
            'categories' => (new CategoryRepository())->allByUser($userId),
            'token' => $this->csrfToken()
        ]);
    }

    public function create(): void
    {
        $userId = $this->requireAuth();
        $this->view('tasks/form', [
            'task' => null,
            'categories' => (new CategoryRepository())->allByUser($userId),
            'token' => $this->csrfToken()
        ]);
    }

    public function store(): void
    {
        $userId = $this->requireAuth();
        $this->verifyCsrf();
        [$title, $description, $status, $categoryId, $dueDate] = $this->validatedInput($userId);
        (new TaskRepository())->create($userId, $title, $description, $status, $categoryId, $dueDate);
        $this->flash('success', 'Tarefa criada com sucesso.');
        $this->redirect('/tasks');
    }

    public function edit(): void
    {
        $userId = $this->requireAuth();
        $id = (int) ($_GET['id'] ?? 0);
        $task = (new TaskRepository())->find($id, $userId);
        if (!$task) { http_response_code(404); exit('Tarefa não encontrada.'); }
        $this->view('tasks/form', [
            'task' => $task,
            'categories' => (new CategoryRepository())->allByUser($userId),
            'token' => $this->csrfToken()
        ]);
    }

    public function update(): void
    {
        $userId = $this->requireAuth();
        $this->verifyCsrf();
        $id = (int) ($_POST['id'] ?? 0);
        if (!(new TaskRepository())->find($id, $userId)) { http_response_code(404); exit('Tarefa não encontrada.'); }
        [$title, $description, $status, $categoryId, $dueDate] = $this->validatedInput($userId);
        (new TaskRepository())->update($id, $userId, $title, $description, $status, $categoryId, $dueDate);
        $this->flash('success', 'Tarefa atualizada com sucesso.');
        $this->redirect('/tasks');
    }

    public function delete(): void
    {
        $userId = $this->requireAuth();
        $this->verifyCsrf();
        (new TaskRepository())->delete((int) ($_POST['id'] ?? 0), $userId);
        $this->flash('success', 'Tarefa excluída.');
        $this->redirect('/tasks');
    }

    private function validatedInput(int $userId): array
    {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'pending';
        $categoryId = ($_POST['category_id'] ?? '') !== '' ? (int) $_POST['category_id'] : null;
        $dueDate = trim($_POST['due_date'] ?? '') ?: null;

        if ($title === '' || mb_strlen($title) > 150) {
            $this->flash('error', 'O título é obrigatório e deve ter até 150 caracteres.');
            $this->redirect('/tasks/create');
        }
        if (!in_array($status, ['pending', 'in_progress', 'done'], true)) $status = 'pending';
        if (!(new CategoryRepository())->belongsToUser($categoryId, $userId)) $categoryId = null;
        return [$title, $description, $status, $categoryId, $dueDate];
    }
}
