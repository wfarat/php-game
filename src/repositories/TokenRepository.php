<?php

namespace App\repositories;

use App\mappers\TokenMapper;
use App\models\Token;
use DateMalformedStringException;
use PDO;

class TokenRepository extends BaseRepository
{

    public function saveToken(string $type, string $token, int $userId): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_tokens (type, token, user_id) VALUES (:type, :token, :user_id)");
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    /**
     * @throws DateMalformedStringException
     */
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
    public function count(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user_tokens");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
