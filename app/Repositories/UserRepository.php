<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

final class UserRepository
{
    private PDO $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function create(string $name, string $email, string $passwordHash): int
    {
        $stmt = $this->db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $passwordHash]);
        return (int) $this->db->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT id, name, email, created_at FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
}
