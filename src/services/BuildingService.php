<?php

namespace App\services;

use App\models\Cost;
use App\repositories\BuildingRepository;
use Exception;

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

    public function upgradeBuilding(int $userId, int $buildingId, Cost $cost): bool
    {
       $resources = $this->resourcesService->getResources($userId);
       if ($cost->canBePaidWith($resources)) {
           $costRes = $cost->resources;
           $this->buildingRepository->beginTransaction();
           try {
               $this->resourcesService->deductResources($userId, $costRes->wood, $costRes->stone, $costRes->food, $costRes->gold);
               $this->buildingRepository->upgradeBuilding($userId, $buildingId, $cost->time);
               $this->buildingRepository->commit();
               return true;
           }
           catch (Exception $e) {
               $this->buildingRepository->rollback();
           }
       }
       return false;
    }
}
