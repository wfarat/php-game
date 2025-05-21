<?php

namespace App\services;

use App\models\Cost;
use App\models\UserResources;
use App\repositories\UnitRepository;

class UnitService
{
    private UnitRepository $unitRepository;
    public ResourcesService $resourcesService;

    public function __construct(UnitRepository $unitRepository, ResourcesService $resourcesService)
    {
        $this->unitRepository = $unitRepository;
        $this->resourcesService = $resourcesService;
    }
    public function getUnits(int $userId): array
    {
        return $this->unitRepository->getUnits($userId);
    }

    public function addUnitsToQueue($userId, int $unitId, int $count, Cost $cost, UserResources $resources): int
    {
        if ($cost->canBePaidWith($resources)) {
            $this->unitRepository->beginTransaction();
            try {
                $this->resourcesService->deductResources($userId, $cost->resources, $resources);
                if ($this->unitRepository->createQueueItem($userId, $unitId, $count, $cost->time)) {
                    $this->unitRepository->commit();
                    return $unitId;
                }
            }
            catch (PDOException $e) {
                error_log($e->getMessage());
                $this->unitRepository->rollback();
            }
        }
        return 0;
    }
}
