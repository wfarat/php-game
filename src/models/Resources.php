<?php

namespace App\models;

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

    public function deduce(Resources $resources): void
    {
        $this->wood -= $resources->wood;
        $this->stone -= $resources->stone;
        $this->food -= $resources->food;
        $this->gold -= $resources->gold;
    }

    public function equals(Resources $resources): bool
    {
        return $this->wood === $resources->wood &&
            $this->stone === $resources->stone &&
            $this->food === $resources->food &&
            $this->gold === $resources->gold;
    }

}
