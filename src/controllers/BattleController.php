<?php

namespace App\controllers;

use App\mappers\UnitMapper;
use App\models\Battle;
use App\services\BattleService;
use App\services\ResourcesService;
use App\services\UnitService;
use DateMalformedStringException;

class BattleController
{

    private BattleService $battleService;
    private ResourcesService $resourcesService;
    private UnitService $unitService;
    public function __construct(BattleService $battleService, ResourcesService $resourcesService, UnitService $unitService)
    {
        $this->battleService = $battleService;
        $this->resourcesService = $resourcesService;
        $this->unitService = $unitService;
    }

    /**
     * @throws DateMalformedStringException
     */
    public function createBattle(int $attackerId, $defenderId): bool
    {
        $attackerStats = UnitMapper::mapToStats($this->unitService->getUnits($attackerId));
        $defenderStats = UnitMapper::mapToStats($this->unitService->getUnits($defenderId));
        $attackerResources = $this->resourcesService->getResources($attackerId);
        $defenderResources = $this->resourcesService->getResources($defenderId);
        return $this->battleService->createBattle($attackerId, $defenderId, $attackerResources, $defenderResources, $attackerStats, $defenderStats);
    }

    public function getBattles(int $userId)
    {
        if (!isset($_SESSION['battles'])) {
            $buildings = $this->battleService->getBattles($userId);
            $_SESSION['battles'] = $buildings;
        }
        return $_SESSION['battles'];
    }

    public function getLatestBattle($id): ?Battle
    {
        return $this->battleService->getLatestBattle($id);
    }
}
