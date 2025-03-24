<?php

namespace App\services;

use App\models\Cost;
use App\observers\BuildingObserver;
use App\repositories\BuildingRepository;
use Exception;

class BuildingService
{

    public BuildingRepository $buildingRepository;
    public ResourcesService $resourcesService;
    public BuildingObserver $observer;
    public function __construct(BuildingRepository $buildingRepository, ResourcesService $resourcesService, BuildingObserver $buildingObserver) {
        $this->buildingRepository = $buildingRepository;
        $this->resourcesService = $resourcesService;
        $this->observer = $buildingObserver;
    }
    public function getBuildings(int $userId): array
    {
        return $this->buildingRepository->getBuildings($userId);
    }

    public function upgradeBuilding(int $userId, int $buildingId, int $level, Cost $cost): int
    {
       $resources = $this->resourcesService->getResources($userId);
       if ($cost->canBePaidWith($resources)) {
             $this->buildingRepository->beginTransaction();
           try {
               $this->resourcesService->deductResources($userId, $cost->resources);
               if ($this->buildingRepository->upgradeBuilding($userId, $buildingId, $level, $cost->time)) {
                   $this->buildingRepository->commit();
                   return $buildingId;
               }
           }
           catch (Exception $e) {
               $this->buildingRepository->rollback();
           }
       }
       return 0;
    }

}
