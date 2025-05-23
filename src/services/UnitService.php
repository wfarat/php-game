<?php

namespace App\services;

use App\models\Cost;
use App\models\UserResources;
use App\repositories\UnitRepository;
use DateMalformedStringException;
use DateTime;
use PDOException;

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

    public function addUnitsToQueue($userId, int $unitId, int $count, Cost $cost, UserResources $resources): ?DateTime
    {
        if ($cost->canBePaidWith($resources)) {
            $this->unitRepository->beginTransaction();
            try {
                $this->resourcesService->deductResources($userId, $cost->resources, $resources);
                $endsAt = $this->unitRepository->createQueueItem($userId, $unitId, $count, $cost->time);
                $this->unitRepository->commit();
                return $endsAt;
            }
            catch (PDOException|DateMalformedStringException $e) {
                error_log($e->getMessage());
                $this->unitRepository->rollback();
            }
        }
        return null;
    }

    public function getQueue(int $userId): array
    {
        return $this->unitRepository->getQueue($userId);
    }

    public function completeUnit($userId, int $unitId): int
    {
        $this->unitRepository->beginTransaction();
        try {
            $count = $this->unitRepository->getCount($userId, $unitId);
            if ($this->unitRepository->addUnits($userId, $unitId, $count)) {
                if ($this->unitRepository->removeFromQueue($userId, $unitId)) {
                    $this->unitRepository->commit();
                    return $count;
                } else {
                    $this->unitRepository->rollback();
                    return 0;
                }
            } else {
                $this->unitRepository->rollback();
                return 0;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->unitRepository->rollback();
            return 0;
        }
    }
}
