<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\TaskRepository;

final class DashboardController extends Controller
{
    public function index(): void
    {
        $userId = $this->requireAuth();
        $repo = new TaskRepository();
        $this->view('dashboard/index', [
            'tasks' => array_slice($repo->allByUser($userId), 0, 5),
            'counts' => $repo->counts($userId),
            'token' => $this->csrfToken()
        ]);
    }
}
