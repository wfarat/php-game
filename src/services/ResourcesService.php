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

    public function deductResources($userId, $wood, $stone, $food, $gold)
    {
        // Deduct resources from the database
        $stmt = Context::getInstance()->db->getConnection()->prepare("UPDATE resources SET 
            wood = wood - ?, stone = stone - ?, food = food - ?, gold = gold - ? 
            WHERE user_id = ?");
        $stmt->execute([$wood, $stone, $food, $gold, $userId]);

        // Notify observers (e.g., UI updates)
        $this->observer->notify($userId);
    }
}
