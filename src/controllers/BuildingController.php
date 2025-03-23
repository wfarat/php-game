<?php

namespace App\controllers;

use App\mappers\ResourcesMapper;
use App\models\Cost;
use App\services\BuildingService;

class BuildingController
{
    public BuildingService $buildingService;

    public function __construct(BuildingService $buildingService) {
        $this->buildingService = $buildingService;
    }

    public function getBuildings(int $userId): array
    {
        $buildings = $this->buildingService->getBuildings($userId);
        $_SESSION['buildings'] = $buildings;
        return $buildings;
    }
    public function upgradeBuilding(): bool
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userId = $_SESSION['user']->id;
        $buildingId = $data['building_id'] ?? null;
        $cost = $data['cost'] ?? null;

        if (!$buildingId || !$cost) {
            echo json_encode(["error" => "Invalid request!"]);
            exit;
        }

        $mappedResource = ResourcesMapper::mapToResources($cost['resources']);
        $upgradeTime = $cost['time'] ?? 0;

        $mappedCost = new Cost($mappedResource, $upgradeTime);
        return $this->buildingService->upgradeBuilding($userId, $buildingId, $mappedCost);
    }
}
