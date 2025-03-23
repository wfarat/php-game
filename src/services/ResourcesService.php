<?php

namespace App\services;

use App\models\Resources;
use App\repositories\ResourcesRepository;

class ResourcesService
{
    public ResourcesRepository $resourcesRepository;
    public function __construct(ResourcesRepository $resourcesRepository) {
        $this->resourcesRepository = $resourcesRepository;
    }

    public function getResources(int $userId): Resources
    {
        return $this->resourcesRepository->getResources($userId);
    }
}
