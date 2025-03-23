<?php

namespace App\repositories;

class UnitRepository extends BaseRepository
{
    function getUnits(int $userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_units 
        INNER JOIN units ON units.id = user_units.unit_id
        WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $unitsData = $stmt->fetchAll();
        return $unitsData;
    }
}
