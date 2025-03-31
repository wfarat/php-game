<?php

namespace App\controllers;

use App\services\ResourcesService;

class ResourcesController
{
    private ResourcesService $resourcesService;

    public function __construct(ResourcesService $resourcesService)
    {
        $this->resourcesService = $resourcesService;
    }

    public function getResources(int $userId): void
    {
        if (!isset($_SESSION['resources'])) {
            $_SESSION['resources'] = $this->resourcesService->getResources($userId);
        }
    }

    public function updateResources(int $userId): void
    {
        $_SESSION['resources'] = $this->resourcesService->getResources($userId);
    }
}