<?php

namespace App\controllers;

use App\helpers\ProductionCalculator;
use App\mappers\ResourcesMapper;
use App\models\Cost;
use App\services\BuildingService;

class BuildingController
{
    public BuildingService $buildingService;
    public function __construct(BuildingService $buildingService) {
        $this->buildingService = $buildingService;
    }

    public function getBuildings(int $userId): void
    {
        if (!isset($_SESSION['buildings'])) {
        $buildings = $this->buildingService->getBuildings($userId);
        $_SESSION['buildings'] = $buildings;
        $_SESSION['resources'] = ProductionCalculator::countProduction($buildings);
        }
    }
    public function upgradeBuilding($data): int
    {

        $userId = $_SESSION['user']->id;
        $buildingId = $data['building_id'] ?? null;
        $production = $data['production'] ?? 0;
        $cost = $data['cost'] ?? null;
        $level = $data['level'] ?? 0;
        if (!$buildingId || !$cost) {
            return 0;
        }

        $mappedResource = ResourcesMapper::mapToResources($cost['resources']);
        $upgradeTime = $cost['time'] ?? 0;

        $mappedCost = new Cost($mappedResource, $upgradeTime);
        $result = $this->buildingService->upgradeBuilding($userId, $buildingId, $level, $mappedCost, $production);
        error_log("Upgrade result: " . print_r($result, true));
        return $result;
    }
}
