<?php

namespace App\repositories;

use App\core\Database;
use PDO;

class BaseRepository
{
    public PDO $pdo;

    public function __construct(Database $db)
    {
        // Inject the DatabaseConnection object
        $this->pdo = $db->getConnection();
    }
    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    public function commit(): void
    {
        $this->pdo->commit();
    }

    public function rollback(): void
    {
        $this->pdo->rollBack();
    }

}
