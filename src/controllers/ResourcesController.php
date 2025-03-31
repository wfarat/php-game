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
            $resources = $this->resourcesService->getResources($userId);
            $_SESSION['resources'] = $resources;
        }
    }
}