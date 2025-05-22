<?php

namespace App\models;

class AttackableUser
{
    public String $name;
    public int $id;
    public int $battlesWon;

    public function __construct(String $name, int $id, int $battlesWon)
    {
        $this->name = $name;
        $this->id = $id;
        $this->battlesWon = $battlesWon;
    }
}
