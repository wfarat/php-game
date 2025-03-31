<?php

namespace App\models;

use App\core\Context;

class Resources
{
    public int $wood;
    public int $stone;
    public int $food;
    public int $gold;

    /**
     * @param int $wood
     * @param int $stone
     * @param int $food
     * @param int $gold
     */
    public function __construct(int $wood, int $stone, int $food, int $gold)
    {
        $this->wood = $wood;
        $this->stone = $stone;
        $this->food = $food;
        $this->gold = $gold;
    }

    public function update($userId): void
    {
        $newResources = Context::getInstance()->resourcesService->getResources($userId);
        $this->wood = $newResources->wood;
        $this->stone = $newResources->stone;
        $this->food = $newResources->food;
        $this->gold = $newResources->gold;
        $_SESSION['resources'] = $this;
    }

}
