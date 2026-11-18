<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/** Design Pattern: Singleton — mantém uma única instância PDO durante a requisição. */
final class Database
{
    private static ?PDO $connection = null;

    private function __construct() {}

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $config = require __DIR__ . '/../../config/database.php';
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['database'],
                $config['charset']
            );

            try {
                self::$connection = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                throw new \RuntimeException('Não foi possível conectar ao banco. Confira config/database.php.');
            }
        }

        return self::$connection;
    }
}
