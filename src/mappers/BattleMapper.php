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
        $battle->winnerId = $battleData['winner_id'];
        $resources = new Resources($battleData['wood'], $battleData['stone'], $battleData['food'], $battleData['gold']);
        $battle->resourcesTaken = $resources;
        return $battle;
    }
}
