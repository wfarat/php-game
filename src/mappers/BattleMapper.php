<?php

namespace App\mappers;

use App\models\Battle;
use App\models\Resources;

class BattleMapper
{
    public static function mapToBattle(array $battleData): Battle
    {
        $battle = new Battle(
            $battleData['attacker_id'],
            $battleData['defender_id'],
        );
        $battle->id = $battleData['id'];
        $battle->winnerId = $battleData['winner_id'];
        $resources = new Resources($battleData['wood'] ?? 0, $battleData['stone'] ?? 0, $battleData['food'] ?? 0, $battleData['gold'] ?? 0);
        $battle->resourcesTaken = $resources;
        return $battle;
    }
}
