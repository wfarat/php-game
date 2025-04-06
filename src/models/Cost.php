<?php

namespace App\models;

class Cost
{
    public Resources $resources;
    public int $time;

    /**
     * @param Resources $resources
     * @param int $time
     */
    public function __construct(Resources $resources, int $time)
    {
        $this->resources = $resources;
        $this->time = $time;
    }

    public function canBePaidWith(Resources $other): bool
    {
       $current = $this->resources;
       if ($current->wood <= $other->wood
           && $current->stone <= $other->stone
           && $current->food <= $other->food
           && $current->gold <= $other->gold) {
           return true;
       }
       return false;
    }

    public function equals(Cost $cost): bool
    {
        return $this->resources->equals($cost->resources) && $this->time === $cost->time;
    }

}
