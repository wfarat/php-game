<?php

namespace App\controllers;

use App\mappers\UnitMapper;
use App\models\Battle;
use App\services\AttackService;
use App\services\ResourcesService;
use App\services\UnitService;

class AttackController
{

    private AttackService $attackService;
    private ResourcesService $resourcesService;
    private UnitService $unitService;
    public function __construct(AttackService $attackService, ResourcesService $resourcesService, UnitService $unitService)
    {
        $this->attackService = $attackService;
        $this->resourcesService = $resourcesService;
        $this->unitService = $unitService;
    }

    public function createBattle(int $attackerId, $defenderId): Battle
    {
        $attackerStats = UnitMapper::mapToStats($this->unitService->getUnits($attackerId));
        $defenderStats = UnitMapper::mapToStats($this->unitService->getUnits($defenderId));
        $defenderResources = $this->resourcesService->getResources($defenderId);
        return $this->attackService->createBattle($attackerId, $defenderId, $defenderResources, $attackerStats, $defenderStats);
    }
}
