<?php

namespace App\services;

use App\Context;
use App\models\Resources;
use App\observers\ResourceObserver;
use App\repositories\ResourcesRepository;

class ResourcesService
{
    public ResourcesRepository $resourcesRepository;
    private ResourceObserver $observer;

    public function __construct(ResourcesRepository $resourcesRepository, ResourceObserver $observer) {
        $this->resourcesRepository = $resourcesRepository;
        $this->observer = $observer;
    }

    public function getResources(int $userId): Resources
    {
        return $this->resourcesRepository->getResources($userId);
    }

    public function deductResources(int $userId, Resources $resources): void
    {
        $this->resourcesRepository->deductResources($userId, $resources);

        // Notify observers (e.g., UI updates)
        $this->observer->notify($userId);
    }
}
