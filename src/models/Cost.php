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

}
