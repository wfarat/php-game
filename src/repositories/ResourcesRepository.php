<?php

namespace App\repositories;

use App\mappers\ResourcesMapper;
use App\models\Resources;

class ResourcesRepository extends BaseRepository
{
    public function getResources(int $userId): Resources
    {
        $stmt = $this->pdo->prepare("SELECT * FROM resources WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $data = $stmt->fetch();
        if (!$data) {
            $stmt = $this->pdo->prepare("INSERT INTO resources (user_id) VALUES (:userId)");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            return new Resources($userId, 5000, 5000, 5000, 5000);
        }
        return ResourcesMapper::mapToResources($data);
    }

    public function deductResources(int $userId, Resources $resources): bool
    {
        $stmt = $this->pdo->prepare("UPDATE resources SET wood = wood - :wood, stone = stone - :stone,
                 food = food - :food, gold = gold - :gold WHERE user_id = :userId");
        $stmt->bindParam(':wood', $resources->wood);
        $stmt->bindParam(':stone', $resources->stone);
        $stmt->bindParam(':food', $resources->food);
        $stmt->bindParam(':gold', $resources->gold);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    public function updateResources(int $userId, Resources $resources): bool
    {
        $stmt = $this->pdo->prepare("UPDATE resources SET wood = :wood, stone = :stone,
                 food = :food, gold = :gold, last_updated = :lastUpdated WHERE user_id = :userId");
        $stmt->bindParam(':wood', $resources->wood);
        $stmt->bindParam(':stone', $resources->stone);
        $stmt->bindParam(':food', $resources->food);
        $stmt->bindParam(':gold', $resources->gold);
        $stmt->bindParam(':lastUpdated', $resources->lastUpdated);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }
}
