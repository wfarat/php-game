<?php

namespace App\mappers;

use App\models\Resources;
use DateMalformedStringException;

class ResourcesMapper
{
    /**
     * @throws DateMalformedStringException
     */
    public static function mapToResources(array $resourcesData): Resources {
    return new Resources(
        $resourcesData['wood'] ?? 0,
        $resourcesData['stone'] ?? 0,
        $resourcesData['food'] ?? 0,
        $resourcesData['gold'] ?? 0,
        DateTimeMapper::map($resourcesData['last_updated'])
    );
}
}
