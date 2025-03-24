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

    public function upgradeBuilding(int $userId, int $buildingId, int $level, int $time): bool {
        if ($level > 0) {
            $stmt = $this->pdo->prepare("UPDATE user_buildings SET current_level = current_level + 1, end_time = :time WHERE user_id = :userId AND building_id = :buildingId");
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO user_buildings (user_id, building_id, current_level, end_time) VALUES (:userId, :buildingId, 1, :time)");
        }
        $end_time = time() + $time;
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':buildingId', $buildingId);
        $stmt->bindParam(':time', $end_time);
        return $stmt->execute();
    }

    public function getNextLevel(int $buildingId, int $level) {
        $stmt = $this->pdo->prepare("SELECT * FROM building_levels WHERE building_id = :buildingId AND level = :level");
        $stmt->bindParam(':buildingId', $buildingId);
        $stmt->bindParam(':level', $level);
        $stmt->execute();
        return $stmt->fetch();
    }
}
