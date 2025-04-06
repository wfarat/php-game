<?php

namespace App\repositories;

use App\mappers\ResourcesMapper;
use App\models\UserResources;
use DateMalformedStringException;
use DateTime;

class ResourcesRepository extends BaseRepository
{
    /**
     * @throws DateMalformedStringException
     */
    public function getResources(int $userId): UserResources
    {
        $stmt = $this->pdo->prepare("SELECT * FROM resources WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $data = $stmt->fetch();
        if (!$data) {
            $stmt = $this->pdo->prepare("INSERT INTO resources (user_id) VALUES (:userId)");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            return new UserResources(5000, 5000, 5000, 5000, new DateTime('now'));
        }
        return ResourcesMapper::mapToUserResources($data);
    }

    public function updateResources(int $userId, UserResources $resources): bool
    {
        $lastUpdatedString = $resources->lastUpdated->format('Y-m-d H:i:s');
        $stmt = $this->pdo->prepare("UPDATE resources SET wood = :wood, stone = :stone,
                 food = :food, gold = :gold, last_updated = :lastUpdated WHERE user_id = :userId");
        $stmt->bindParam(':wood', $resources->wood);
        $stmt->bindParam(':stone', $resources->stone);
        $stmt->bindParam(':food', $resources->food);
        $stmt->bindParam(':gold', $resources->gold);
        $stmt->bindParam(':lastUpdated', $lastUpdatedString);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }
}
