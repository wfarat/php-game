<?php

namespace App\services;

use App\models\Cost;
use App\models\Resources;
use App\observers\BuildingObserver;
use App\repositories\BuildingRepository;
use Exception;
use PDOException;

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

    public function upgradeBuilding(int $userId, int $buildingId, int $level, Cost $cost, int $production, Resources $resources): int
    {
       if ($cost->canBePaidWith($resources)) {
             $this->buildingRepository->beginTransaction();
           try {
               $this->resourcesService->deductResources($userId, $cost->resources, $resources);
               if ($this->buildingRepository->upgradeBuilding($userId, $buildingId, $level, $cost->time, $production)) {
                   $this->buildingRepository->commit();
                   return $buildingId;
               }
           }
           catch (PDOException $e) {
               error_log($e->getMessage());
               $this->buildingRepository->rollback();
           }
       }
       return 0;
    }

}
