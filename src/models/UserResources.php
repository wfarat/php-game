<?php

namespace App\models;

use DateTime;

class UserResources extends Resources
{
    public ?DateTime $lastUpdated;

    /**
     * @param int $wood
     * @param int $stone
     * @param int $food
     * @param int $gold
     * @param DateTime|null $lastUpdated
     */
    public function __construct(int $wood, int $stone, int $food, int $gold, ?DateTime $lastUpdated = null)
    {
        parent::__construct($wood, $stone, $food, $gold);
        $this->lastUpdated = $lastUpdated ?? new DateTime('now');
    }

    public function update(UserResources $resources):void
    {
        $this->wood = $resources->wood;
        $this->stone = $resources->stone;
        $this->food = $resources->food;
        $this->gold = $resources->gold;
        $this->lastUpdated = $resources->lastUpdated;
    }

}