<?php

namespace App\mappers;

use App\models\Resources;

class ResourcesMapper
{
public static function mapToResources(array $resourcesData): Resources {
    return new Resources(
        $resourcesData['user_id'],
        $resourcesData['wood'],
        $resourcesData['stone'],
        $resourcesData['food'],
        $resourcesData['gold']
    );
}
}
