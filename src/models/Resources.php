<?php

namespace App\models;

use App\services\ResourcesService;

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

    public function add(Resources $resources): Resources
    {
        $this->wood += $resources->wood;
        $this->stone += $resources->stone;
        $this->food += $resources->food;
        $this->gold += $resources->gold;
        return $this;
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

    public function multipliedBy(float $multiplier): Resources
    {
        return new Resources($this->wood * $multiplier, $this->stone * $multiplier, $this->food * $multiplier, $this->gold * $multiplier);
    }

    public function isEmpty(): bool
    {
        return $this->wood === 0 && $this->stone === 0 && $this->food === 0 && $this->gold === 0;
    }
}
