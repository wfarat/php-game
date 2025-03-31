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
}
