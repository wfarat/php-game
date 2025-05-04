<?php

namespace App\models;

use App\core\Context;
use DateTime;

class Building
{
    public int $user_id;
    public int $building_id;
    public int $level;
    public string $name;
    public string $description;
    public string $image;
    public Production $production;
    public NextLevel $nextLevel;
    public DateTime $endsBuildingAt;
    /**
     * @param int $user_id
     * @param int $building_id
     * @param int $level
     * @param string $name
     * @param string $description
     * @param string $image
     */
    public function __construct(int $user_id, int $building_id, int $level, string $name, string $description, string $image, DateTime $endsBuildingAt)
    {
        $this->user_id = $user_id;
        $this->building_id = $building_id;
        $this->level = $level;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->endsBuildingAt = $endsBuildingAt;
    }

    public function update(): void
    {
        $end_time = time() + $this->nextLevel->cost->time;
        $this->endsBuildingAt = new DateTime("@$end_time");
        $this->level++;
        $this->production->amount = $this->nextLevel->production;
        $nextLevel = Context::getInstance()->buildingRepository->getNextLevel($this->building_id, $this->level + 1);
        $this->nextLevel = $nextLevel;
    }

    public function isNextLevelPossible(): bool
    {
        return $this->nextLevel->cost->time > 0;
    }
}
