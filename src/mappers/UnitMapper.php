<?php

namespace App\mappers;

use App\models\Cost;
use App\models\Resources;
use App\models\Stats;
use App\models\Unit;

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
        $data['user_id'],
        $data['count'],
        $data['name'],
        $data['description'],
        $data['img'],
        $cost,
        $stats
    );
}
}