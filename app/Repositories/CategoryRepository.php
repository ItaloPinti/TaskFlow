<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

final class CategoryRepository
{
    private $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function allByUser(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE user_id=:user_id ORDER BY name');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function create(int $userId, string $name): void
    {
        $stmt = $this->db->prepare('INSERT INTO categories (user_id, name) VALUES (:user_id, :name)');
        $stmt->execute(['user_id' => $userId, 'name' => $name]);
    }

    public function delete(int $id, int $userId): void
    {
        $stmt = $this->db->prepare('DELETE FROM categories WHERE id=:id AND user_id=:user_id');
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }

    public function belongsToUser(?int $id, int $userId): bool
    {
        if (!$id) return true;
        $stmt = $this->db->prepare('SELECT id FROM categories WHERE id=:id AND user_id=:user_id');
        $stmt->execute(['id'=>$id, 'user_id'=>$userId]);
        return (bool) $stmt->fetch();
    }
}
