<?php

namespace App\models;

class Battle
{
    public int $attackerId;
    public int $defenderId;
    public int $winnerId;
    public Stats $attackerStats;
    public Stats $defenderStats;
    public Resources $resourcesTaken;

    public function __construct(int $attackerId, int $defenderId, Stats $attackerStats, Stats $defenderStats)
    {
        $this->attackerId = $attackerId;
        $this->defenderId = $defenderId;
        $this->attackerStats = $attackerStats;
        $this->defenderStats = $defenderStats;
        $this->winnerId = $this->determineWinner();
    }

    public function determineWinner(): int
    {
        $attackerRound = $this->attackerStats->speed >= $this->defenderStats->speed;
        while ($this->attackerStats->defense > 0 && $this->defenderStats->defense > 0) {
            if ($attackerRound) {
                $this->defenderStats->defense -= $this->attackerStats->attack;
                $attackerRound = false;
            } else {
                $this->attackerStats->defense -= $this->defenderStats->attack;
                $attackerRound = true;
            }
        }
        return $this->defenderStats->defense <= 0 ? $this->attackerId : $this->defenderId;
    }
}
