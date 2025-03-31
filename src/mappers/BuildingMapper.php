<?php

namespace App\mappers;

use App\models\Building;
use App\models\Cost;
use App\models\Production;
use App\models\ProductionKind;
use App\models\ProductionType;
use App\models\Resources;

class BuildingMapper
{
    /**
     * @throws \DateMalformedStringException
     */
    public static function mapToBuilding(array $buildingData): Building {
    $result  = new Building(
        $buildingData['user_id'] ?? $_SESSION['user']->id,
        $buildingData['building_id'] ?? $buildingData['id'],
        $buildingData['current_level'] ?? 0,
        $buildingData['name'],
        $buildingData['description'],
        $buildingData['img'],
        DateTimeMapper::map($buildingData['end_time'])
    );
    $productionKind = ProductionKind::tryFrom($buildingData['production_kind']);
    $productionType = ProductionType::tryFrom($buildingData['production_type']);
    $production = new Production($productionType, $buildingData['production_amount'] ?? 0, $productionKind);
    $result->production = $production;
    $resources = new Resources(
        $buildingData['wood'] ?? 0,
        $buildingData['stone'] ?? 0,
        $buildingData['food'] ?? 0,
        $buildingData['gold'] ?? 0
    );
    $result->nextLevelCost = new Cost($resources, $buildingData['time'] ?? 0);
    $result->nextLevelProduction = $buildingData['production'] ?? 0;
    return $result;
}
}
