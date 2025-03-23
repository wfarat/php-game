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
}
