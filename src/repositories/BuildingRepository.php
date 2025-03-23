<?php

namespace App\repositories;

class BuildingRepository extends BaseRepository
{
    public function getBuildings(int $userId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM user_buildings 
     INNER JOIN buildings ON buildings.id = user_buildings.building_id 
     WHERE user_buildings.user_id = :userId"
        );        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $buildingsData = $stmt->fetchAll();
        return $buildingsData;
    }
}
