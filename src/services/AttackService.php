<?php

namespace App\services;

use App\models\Battle;
use App\models\Stats;
use App\models\UserResources;

class AttackService
{

    private ResourcesService $resourcesService;

    public function __construct(ResourcesService $resourcesService) {
        $this->resourcesService = $resourcesService;
}
    public function createBattle(int $attackerId, $defenderId, UserResources $defenderResources, Stats $attackerStats, Stats $defenderStats)
    {
        $battle = new Battle($attackerId, $defenderId, $attackerStats, $defenderStats);
        if ($battle->attackerId === $battle->winnerId) {
            $resourcesTaken = $defenderResources->multipliedBy(0.2);
            $defenderResources->deduce($resourcesTaken);
            $battle->resourcesTaken = $resourcesTaken;
        }

        return $battle;
    }
}
