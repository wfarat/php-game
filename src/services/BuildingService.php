<?php

namespace App\services;

use App\repositories\BuildingRepository;
use App\repositories\ResourcesRepository;

class BuildingService
{

    public BuildingRepository $buildingRepository;
    public ResourcesService $resourcesService;
    public function __construct(BuildingRepository $buildingRepository, ResourcesService $resourcesService) {
        $this->buildingRepository = $buildingRepository;
        $this->resourcesService = $resourcesService;
    }
    public function getBuildings(int $userId): array
    {
        return $this->buildingRepository->getBuildings($userId);
    }

    public function upgradeBuilding(int $userId, int $buildingId)
    {
    }
}
