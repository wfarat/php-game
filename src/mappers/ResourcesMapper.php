<?php

namespace App\mappers;

use App\models\Resources;

class ResourcesMapper
{
public static function mapToResources(array $resourcesData): Resources {
    return new Resources(
        $resourcesData['wood'] ?? 0,
        $resourcesData['stone'] ?? 0,
        $resourcesData['food'] ?? 0,
        $resourcesData['gold'] ?? 0
    );
}
}
