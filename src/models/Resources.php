<?php

namespace App\models;

use App\core\Context;
use DateTime;

class Resources
{
    public int $wood;
    public int $stone;
    public int $food;
    public int $gold;
    public ?DateTime $lastUpdated;
    /**
     * @param int $wood
     * @param int $stone
     * @param int $food
     * @param int $gold
     */
    public function __construct(int $wood, int $stone, int $food, int $gold, ?DateTime $lastUpdated = null)
    {
        $this->wood = $wood;
        $this->stone = $stone;
        $this->food = $food;
        $this->gold = $gold;
        $this->lastUpdated = $lastUpdated;
    }

    public function update(Resources $resources):void
    {
        $this->wood = $resources->wood;
        $this->stone = $resources->stone;
        $this->food = $resources->food;
        $this->gold = $resources->gold;
    }

    public function add(Resources $resources):void
    {
        $this->wood += $resources->wood;
        $this->stone += $resources->stone;
        $this->food += $resources->food;
        $this->gold += $resources->gold;
    }

    public function multiply(int $times): void
    {
        $this->wood *= $times;
        $this->stone *= $times;
        $this->food *= $times;
        $this->gold *= $times;
    }
}
