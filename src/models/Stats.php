<?php

namespace App\models;

class Stats
{
    public int $attack;
    public int $defense;
    public int $speed;

    /**
     * @param int $attack
     * @param int $defense
     * @param int $speed
     */
    public function __construct(int $attack, int $defense, int $speed)
    {
        $this->attack = $attack;
        $this->defense = $defense;
        $this->speed = $speed;
    }

    public function multiply(int $count): Stats
    {
        return new Stats($this->attack*$count, $this->defense*$count, $this->speed*$count);
    }

    public function add(Stats $other): Stats
    {
        return new Stats(
            $this->attack + $other->attack,
            $this->defense + $other->defense,
            $this->speed + $other->speed
        );
    }


}
