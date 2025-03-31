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

    private function countProduction(array $buildings): Resources
    {
        $wood = 0;
        $food = 0;
        $stone = 0;
        $gold = 0;
        foreach ($buildings as $building) {
            $production = $building->production;
            if ($production->type == ProductionType::Resource) {
                switch ($production->kind) {
                    case ProductionKind::Food:
                        $food += $production->amount;
                        break;
                    case ProductionKind::Gold:
                        $gold += $production->amount;
                        break;
                    case ProductionKind::Stone:
                        $stone += $production->amount;
                        break;
                    case ProductionKind::Wood:
                        $wood += $production->wood;
                        break;
                    default:
                }
            }
        }
        return new Resources($wood, $stone, $food, $gold);
    }
}