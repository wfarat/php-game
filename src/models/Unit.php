<?php

namespace App\models;

class Unit
{
    public int $unitId;
    public int $userId;
    public int $count;
    public string $name;
    public string $description;
    public string $image;
    public Cost $cost;
    public Stats $stats;

    /**
     * @param int $unitId
     * @param int $userId
     * @param int $count
     * @param string $name
     * @param string $description
     * @param string $image
     * @param Cost $cost
     * @param Stats $stats
     */
    public function __construct(int $unitId, int $userId, int $count, string $name, string $description, string $image, Cost $cost, Stats $stats)
    {
        $this->unitId = $unitId;
        $this->userId = $userId;
        $this->count = $count;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->cost = $cost;
        $this->stats = $stats;
    }


}