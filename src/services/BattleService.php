<?php

namespace App\services;

use App\models\Battle;
use App\models\Stats;
use App\models\UserResources;
use App\repositories\BattleRepository;
use PDOException;

class BattleService
{

    private ResourcesService $resourcesService;
    private BattleRepository $battleRepository;
    public function __construct(ResourcesService $resourcesService, BattleRepository $battleRepository) {
        $this->resourcesService = $resourcesService;
        $this->battleRepository = $battleRepository;
}
    public function createBattle(int $attackerId, $defenderId, UserResources $defenderResources, Stats $attackerStats, Stats $defenderStats): Battle
    {
        $battle = new Battle($attackerId, $defenderId);
        $battle->winnerId = $battle->determineWinner();
        $battle->attackerStats = $attackerStats;
        $battle->defenderStats = $defenderStats;
        if ($battle->attackerId === $battle->winnerId) {
            $resourcesTaken = $defenderResources->multipliedBy(0.2);
            $battle->resourcesTaken = $resourcesTaken;
        }
        try {
            $this->battleRepository->beginTransaction();
            if ($this->battleRepository->save($battle)) {
                $this->resourcesService->deductResources($battle->defenderId, $resourcesTaken, $defenderResources);
                $this->resourcesService->addResources($battle->attackerId, $resourcesTaken, $defenderResources);
                $this->battleRepository->commit();
            } else {
                $this->battleRepository->rollback();
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $this->battleRepository->rollback();
        }
        return $battle;
    }
}
