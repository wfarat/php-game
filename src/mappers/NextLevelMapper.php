<?php

namespace App\mappers;

use App\models\Cost;
use App\models\NextLevel;
use App\models\Resources;

class NextLevelMapper
{
    public static function mapToNextLevel(array $data): NextLevel
    {

        return new NextLevel(new Cost(
            new Resources(
                $data['wood'] ?? 0,
                $data['stone'] ?? 0,
                $data['food'] ?? 0,
                $data['gold'] ?? 0),
            $data['time']
        ), $data['production']);
    }
}
