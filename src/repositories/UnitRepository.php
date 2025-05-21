<?php

namespace App\repositories;

use App\mappers\UnitMapper;

class UnitRepository extends BaseRepository
{
    function getUnits(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM units
        LEFT JOIN user_units ON units.id = user_units.unit_id AND user_units.user_id = :userId
        LEFT JOIN unit_costs ON units.id = unit_costs.unit_id"
        );
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $unitsData = $stmt->fetchAll();
        return array_map([UnitMapper::class, 'mapToUnit'], $unitsData);
    }

    public function createQueueItem($userId, int $unitId, int $count, int $time): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_units (user_id, unit_id, count, end_time) VALUES (:userId, :unitId, :count, :end_time)");
        $end_time = date('Y-m-d H:i:s', time() + $time);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':unitId', $unitId);
        $stmt->bindParam(':count', $count);
        $stmt->bindParam(':end_time', $end_time);
        return $stmt->execute();

    }
}
