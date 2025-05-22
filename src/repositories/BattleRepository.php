<?php

namespace App\repositories;

use App\mappers\BattleMapper;
use App\models\Battle;

class BattleRepository extends BaseRepository
{

    function getBattles(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM battles WHERE user_id = :userId");
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return array_map([BattleMapper::class, 'mapToBattle'], $data);
    }

    function save(Battle $battle): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO battles (attacker_id, defender_id, winner_id, wood, food, stone, gold) VALUES (:attacker_id, :defender_id, :winner_id, :wood, :food, :stone, :gold)");
        $stmt->bindParam(':attacker_id', $battle->attackerId);
        $stmt->bindParam(':defender_id', $battle->defenderId);
        $stmt->bindParam(':winner_id', $battle->winnerId);
        $stmt->bindParam(":wood", $battle->resourcesTaken->wood);
        $stmt->bindParam(":stone", $battle->resourcesTaken->stone);
        $stmt->bindParam(":food", $battle->resourcesTaken->food);
        $stmt->bindParam(":gold", $battle->resourcesTaken->gold);
        return $stmt->execute();
    }
}
