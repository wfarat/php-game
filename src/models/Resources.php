<?php

namespace App\models;

class Resources
{
    public int $userId;
    public int $wood;
    public int $stone;
    public int $food;
    public int $gold;

    /**
     * @param int $userId
     * @param int $wood
     * @param int $stone
     * @param int $food
     * @param int $gold
     */
    public function __construct(int $userId, int $wood, int $stone, int $food, int $gold)
    {
        $this->userId = $userId;
        $this->wood = $wood;
        $this->stone = $stone;
        $this->food = $food;
        $this->gold = $gold;
    }


}
