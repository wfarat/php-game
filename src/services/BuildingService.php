<?php

namespace App\services;

use App\models\Cost;
use App\models\ProductionKind;
use App\models\ProductionType;
use App\models\Resources;
use App\models\UserResources;
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

    public function upgradeBuilding(int $userId, int $buildingId, int $level, Cost $cost, int $production, UserResources $resources): int
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
    public function countProduction(array $buildings): ?Resources
    {
        $wood = 0;
        $food = 0;
        $stone = 0;
        $gold = 0;
        foreach ($buildings as $building) {
            $production = $building->production;
            if ($production->type == ProductionType::Resource) {
                switch ($production->kind) {
                    case ProductionKind::Food:
                        $food += $production->amount;
                        break;
                    case ProductionKind::Gold:
                        $gold += $production->amount;
                        break;
                    case ProductionKind::Stone:
                        $stone += $production->amount;
                        break;
                    case ProductionKind::Wood:
                        $wood += $production->amount;
                        break;
                    default:
                }
            }
        }
        return new Resources($wood, $stone, $food, $gold);
    }
}
