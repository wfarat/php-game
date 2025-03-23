<?php

namespace App\repositories;

use App\core\Database;
use App\mappers\TokenMapper;
use App\models\Token;
use Dotenv\Util\Str;
use PDO;

class TokenRepository
{

    private PDO $pdo;

    public function __construct(Database $db)
    {
        // Inject the DatabaseConnection object
        $this->pdo = $db->getConnection();
    }

    public function saveToken(string $type, string $token, int $userId): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_tokens (type, token, user_id) VALUES (:type, :token, :user_id)");
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    public function getToken(string $token): ?Token
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_tokens WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$tokenData) {
            return null;
        }
        return TokenMapper::mapToToken($tokenData);
    }

    public function deleteToken(string $token): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_tokens WHERE token = :token");
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }
}
