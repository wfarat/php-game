<?php

namespace App\controllers;

use App\helpers\ProductionCalculator;
use App\mappers\ResourcesMapper;
use App\models\Cost;
use App\models\Resources;
use App\services\BuildingService;
use DateMalformedStringException;

class BuildingController
{
    public BuildingService $buildingService;
    public function __construct(BuildingService $buildingService) {
        $this->buildingService = $buildingService;
    }

    public function getBuildings(int $userId): array
    {
        if (!isset($_SESSION['buildings'])) {
        $buildings = $this->buildingService->getBuildings($userId);
        $_SESSION['buildings'] = $buildings;
        }
        return $_SESSION['buildings'];
    }
    public function upgradeBuilding($data, Resources $resources): int
    {

        $userId = $_SESSION['user']->id;
        $buildingId = $data['building_id'] ?? null;
        $production = $data['production'] ?? 0;
        $cost = $data['cost'] ?? null;
        $level = $data['level'] ?? 0;
        if (!$buildingId || !$cost) {
            return 0;
        }
        try {
            $mappedResource = ResourcesMapper::mapToResources($cost['resources']);
            $upgradeTime = $cost['time'] ?? 0;
            $mappedCost = new Cost($mappedResource, $upgradeTime);
            return $this->buildingService->upgradeBuilding($userId, $buildingId, $level, $mappedCost, $production, $resources);
        } catch (DateMalformedStringException $e) {
            error_log($e->getMessage());
        }
        return 0;
    }
}
