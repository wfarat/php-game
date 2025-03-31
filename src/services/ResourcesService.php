<?php

namespace App\services;

use App\models\Resources;
use App\repositories\ResourcesRepository;

class ResourcesService
{
    private ResourcesRepository $resourcesRepository;

    public function __construct(ResourcesRepository $resourcesRepository) {
        $this->resourcesRepository = $resourcesRepository;
    }

    public function getResources(int $userId): Resources
    {
        return $this->resourcesRepository->getResources($userId);
    }

    public function deductResources(int $userId, Resources $resources): void
    {
        $this->resourcesRepository->deductResources($userId, $resources);
    }
}
