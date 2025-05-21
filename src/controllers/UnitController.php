<?php

namespace App\controllers;

use App\mappers\ResourcesMapper;
use App\models\Cost;
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

    public function trainUnits(mixed $data, UserResources $resources): int
    {
        $userId = $_SESSION['user']->id;
        $unitId = $data['unitId'] ?? null;
        $count = $data['count'] ?? 0;
        $cost = $data['cost'] ?? null;
        $mappedResource = ResourcesMapper::mapToResources($cost['resources']);
        $upgradeTime = $cost['time'] ?? 0;
        $mappedCost = new Cost($mappedResource, $upgradeTime);
        return $this->unitService->addUnitsToQueue($userId, $unitId, $count, $mappedCost, $resources);
    }
}
