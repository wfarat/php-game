<?php

namespace App\repositories;

use App\mappers\BuildingMapper;

class BuildingRepository extends BaseRepository
{
    public function getBuildings(int $userId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM buildings 
            LEFT JOIN user_buildings ON buildings.id = user_buildings.building_id 
            AND user_buildings.user_id = :userId 
            LEFT JOIN building_levels ON building_levels.building_id = buildings.id 
            AND building_levels.level = COALESCE(user_buildings.current_level, 0) + 1"
        );
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $buildingsData = $stmt->fetchAll();
        return array_map([BuildingMapper::class, 'mapToBuilding'], $buildingsData);
    }
}
