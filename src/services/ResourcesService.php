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

    public function deductResources(int $userId, Resources $deducted, Resources $current): void
    {
        $current->deduce($deducted);
        $this->updateResources($userId, $current);
    }

    public function updateResources(int $userId, Resources $resources): void
    {
        $this->resourcesRepository->updateResources($userId, $resources);
    }
}
