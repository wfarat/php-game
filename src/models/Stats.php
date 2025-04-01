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


}