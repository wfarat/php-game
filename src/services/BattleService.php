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
    private UserService $userService;

    public function __construct(ResourcesService $resourcesService, BattleRepository $battleRepository, UserService $userService)
    {
        $this->resourcesService = $resourcesService;
        $this->battleRepository = $battleRepository;
        $this->userService = $userService;
    }

    public function createBattle(int $attackerId, $defenderId, UserResources $attackerResources, UserResources $defenderResources, Stats $attackerStats, Stats $defenderStats): bool
    {
        $battle = new Battle($attackerId, $defenderId);
        $battle->attackerStats = $attackerStats;
        $battle->defenderStats = $defenderStats;
        $battle->winnerId = $battle->determineWinner();
        $result = $battle->attackerId === $battle->winnerId;
        try {
            $this->battleRepository->beginTransaction();
            if ($result) {
                $resourcesTaken = $defenderResources->multipliedBy(0.2);
                $battle->resourcesTaken = $resourcesTaken;
                $this->resourcesService->deductResources($battle->defenderId, $resourcesTaken, $defenderResources);
                $this->resourcesService->addResources($battle->attackerId, $resourcesTaken, $attackerResources);
                $this->userService->updateBattlesWon($battle->attackerId);
            } else {
                $this->userService->updateBattlesWon($battle->defenderId);
            }
            if ($this->battleRepository->save($battle)) {
                $this->battleRepository->commit();
            } else {
                $this->battleRepository->rollback();
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $this->battleRepository->rollback();
        }
        return $result;
    }

    public function getBattles(int $userId): array
    {
        return $this->battleRepository->getBattles($userId);
    }

    public function getLatestBattle($id): ?Battle
    {
        return $this->battleRepository->getLatestBattleForUser($id);
    }
}
