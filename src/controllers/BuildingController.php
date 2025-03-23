<?php

namespace App\controllers;

use App\services\BuildingService;

class BuildingController
{
    public BuildingService $buildingService;

    public function __construct(BuildingService $buildingService) {
        $this->buildingService = $buildingService;
    }

    public function getBuildings(int $userId): array
    {
        return $this->buildingService->getBuildings($userId);
    }
    public function upgradeBuilding(int $userId, int $buildingId): bool
    {
        return $this->buildingService->upgradeBuilding($userId, $buildingId);
    }
}
