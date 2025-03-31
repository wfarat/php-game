<?php

namespace App\controllers;

use App\models\ProductionKind;
use App\models\ProductionType;
use App\models\Resources;
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
        $_SESSION['resources']->update($this->resourcesService->getResources($userId));
    }

    public function produceResources(): void
    {
        $buildings = $_SESSION['buildings'];
        $_SESSION['resources']->add($this->countProduction($buildings));
    }

}