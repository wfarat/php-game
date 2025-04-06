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
}
