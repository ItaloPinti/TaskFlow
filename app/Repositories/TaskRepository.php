<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

/** Design Pattern: Repository — concentra o acesso aos dados das tarefas. */
final class TaskRepository
{
    private PDO $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function allByUser(int $userId): array
    {
        $stmt = $this->db->prepare(
            'SELECT t.*, c.name AS category_name FROM tasks t
             LEFT JOIN categories c ON c.id = t.category_id
             WHERE t.user_id = :user_id ORDER BY t.created_at DESC'
        );
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function find(int $id, int $userId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM tasks WHERE id = :id AND user_id = :user_id');
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    public function create(int $userId, string $title, string $description, string $status, ?int $categoryId, ?string $dueDate): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO tasks (user_id, title, description, status, category_id, due_date)
             VALUES (:user_id, :title, :description, :status, :category_id, :due_date)'
        );
        $stmt->execute([
            'user_id' => $userId, 'title' => $title, 'description' => $description,
            'status' => $status, 'category_id' => $categoryId, 'due_date' => $dueDate ?: null
        ]);
    }

    public function update(int $id, int $userId, string $title, string $description, string $status, ?int $categoryId, ?string $dueDate): void
    {
        $stmt = $this->db->prepare(
            'UPDATE tasks SET title=:title, description=:description, status=:status,
             category_id=:category_id, due_date=:due_date WHERE id=:id AND user_id=:user_id'
        );
        $stmt->execute([
            'title' => $title, 'description' => $description, 'status' => $status,
            'category_id' => $categoryId, 'due_date' => $dueDate ?: null,
            'id' => $id, 'user_id' => $userId
        ]);
    }

    public function delete(int $id, int $userId): void
    {
        $stmt = $this->db->prepare('DELETE FROM tasks WHERE id = :id AND user_id = :user_id');
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }

    public function counts(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) total,
             SUM(status='pending') pending,
             SUM(status='in_progress') in_progress,
             SUM(status='done') done
             FROM tasks WHERE user_id=:user_id"
        );
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch() ?: ['total'=>0,'pending'=>0,'in_progress'=>0,'done'=>0];
    }
}
