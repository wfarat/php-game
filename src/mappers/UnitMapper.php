<?php

namespace App\mappers;

use App\models\Cost;
use App\models\QueueItem;
use App\models\Resources;
use App\models\Stats;
use App\models\Unit;
use DateMalformedStringException;

class UnitMapper
{
    public static function mapToUnit(array $data): Unit
    {
        $stats = new Stats(
            $data['attack'],
            $data['defense'],
            $data['speed']
        );
    $resources = new Resources(
        $data['wood'],
        $data['stone'],
        $data['food'],
        $data['gold']
    );
    $cost = new Cost($resources, $data['time']);
    return new Unit(
        $data['unit_id'],
        $data['user_id'] ?? $_SESSION['user']->id,
        $data['count'] ?? 0,
        $data['name'],
        $data['description'],
        $data['img'],
        $cost,
        $stats
    );
}

    /**
     * @throws DateMalformedStringException
     */
    public static function mapToQueueItem(array $data): QueueItem
    {
        return new QueueItem(
            $data['unit_id'],
            $data['user_id'],
            $data['count'],
            $data['name'],
            DateTimeMapper::map($data['ends_at'])
        );
    }

    public static function mapToStats(array $data): Stats
    {
        return array_reduce($data, function($acc, $value){
            return $acc->add($value->totalStats());
        }, new Stats(0, 0, 0));
    }
}
