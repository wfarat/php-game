<?php

namespace App\services;

use App\models\Resources;
use App\models\UserResources;
use App\repositories\ResourcesRepository;

class ResourcesService
{
    private ResourcesRepository $resourcesRepository;

    public function __construct(ResourcesRepository $resourcesRepository) {
        $this->resourcesRepository = $resourcesRepository;
    }

    public function getResources(int $userId): UserResources
    {
        return $this->resourcesRepository->getResources($userId);
    }

    public function deductResources(int $userId, Resources $deducted, UserResources $current): void
    {
        $current->deduce($deducted);
        $this->updateResources($userId, $current);
    }

    public function addResources(int $userId, Resources $added, UserResources $current): void
    {
        $current->add($added);
        $this->updateResources($userId, $current);
    }

    public function updateResources(int $userId, UserResources $resources): void
    {
        $this->resourcesRepository->updateResources($userId, $resources);
    }
}
