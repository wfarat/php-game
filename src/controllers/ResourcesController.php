<?php

namespace App\controllers;

use App\helpers\ProductionCalculator;
use App\models\Resources;
use App\models\UserResources;
use App\services\ResourcesService;
use DateTime;

class ResourcesController
{
    private ResourcesService $resourcesService;

    public function __construct(ResourcesService $resourcesService)
    {
        $this->resourcesService = $resourcesService;
    }

    public function getResources(int $userId): UserResources
    {
        if (!isset($_SESSION['resources'])) {
            $_SESSION['resources'] = $this->resourcesService->getResources($userId);
        }
        return $_SESSION['resources'];
    }

    public function updateResources(int $userId): void
    {
        $_SESSION['resources']->update($this->resourcesService->getResources($userId));
    }

    public function getProduction(array $buildings): ?Resources
    {
        if (!isset($_SESSION['production'])) {
            $_SESSION['production'] = ProductionCalculator::countProduction($buildings);
            $_SESSION['resources']->update($this->produceResources($buildings));
        }
        return $_SESSION['production'];
    }
    public function produceResources(array $buildings): UserResources
    {
        $production = ProductionCalculator::countProduction($buildings);
        $lastUpdated = $_SESSION['resources']->lastUpdated;
        $currentTime = new DateTime('now');
        $interval = $currentTime->diff($lastUpdated);
        $secondsPassed = ($interval->days * 24 * 60 * 60) +
            ($interval->h * 60 * 60) +
            ($interval->i * 60) +
            $interval->s;
        $production->multiply($secondsPassed);
        $_SESSION['resources']->add($production);
        $_SESSION['resources']->lastUpdated = $currentTime;
        return $_SESSION['resources'];
    }

}