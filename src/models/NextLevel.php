<?php

namespace App\models;

class NextLevel
{
    public Cost $cost;
    public int $production;

    /**
     * @param Cost $cost
     * @param int $production
     */
    public function __construct(Cost $cost, int $production)
    {
        $this->cost = $cost;
        $this->production = $production;
    }


}
