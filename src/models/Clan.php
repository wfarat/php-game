<?php

namespace App\models;

class Clan
{

    public int $id;
    public string $name;
    public string $description;
    public int $level;
    public int $members_count;
    public ?string $img;
    public int $leader_id;

    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param int $level
     * @param int $members_count
     * @param ?string $img
     * @param int $leader_id
     */
    public function __construct(int $id, string $name, string $description, int $level, int $members_count, ?string $img, int $leader_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->level = $level;
        $this->members_count = $members_count;
        $this->img = $img;
        $this->leader_id = $leader_id;
    }


}
