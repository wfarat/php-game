<?php

namespace App\controllers;

use App\mappers\ResourcesMapper;
use App\models\Cost;
use App\models\QueueItem;
use App\models\UserResources;
use App\services\UnitService;

class UnitController
{
    private UnitService $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function getUnits(int $userId): array
    {
        if (!isset($_SESSION['units'])) {
            $_SESSION['units'] = $this->unitService->getUnits($userId);
        }
        return $_SESSION['units'];
    }
    public function getQueue(int $userId): array
    {
        if (!isset($_SESSION['queue'])) {
            $_SESSION['queue'] = $this->unitService->getQueue($userId);
        }
        return $_SESSION['queue'];
    }

    public function trainUnits(mixed $data, UserResources $resources): bool
    {
        $userId = $_SESSION['user']->id;
        $unitId = $data['unitId'] ?? 0;
        $count = $data['count'] ?? 0;
        $cost = $data['cost'] ?? null;
        $name = $data['name'] ?? null;
        $mappedResource = ResourcesMapper::mapToResources($cost['resources']);
        $upgradeTime = $cost['time'] ?? 0;
        $mappedCost = new Cost($mappedResource, $upgradeTime);
        $endsAt = $this->unitService->addUnitsToQueue($userId, $unitId, $count, $mappedCost, $resources);
        $_SESSION['queue'][] = new QueueItem($unitId, $userId, $count, $name, $endsAt);
        return true;
    }

    public function completeUnit($userId, int $unitId): int
    {
        return $this->unitService->completeUnit($userId, $unitId);
    }
}
