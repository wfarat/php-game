<?php

namespace App\models;

class Building
{
    public int $user_id;
    public int $building_id;
    public int $level;
    public string $name;
    public string $description;
    public string $image;
    public Production $production;
    public Cost $nextLevelCost;
    public int $nextLevelProduction;

    /**
     * @param int $user_id
     * @param int $building_id
     * @param int $level
     * @param string $name
     * @param string $description
     * @param string $image
     */
    public function __construct(int $user_id, int $building_id, int $level, string $name, string $description, string $image)
    {
        $this->user_id = $user_id;
        $this->building_id = $building_id;
        $this->level = $level;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
    }


}
