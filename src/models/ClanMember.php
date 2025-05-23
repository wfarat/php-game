<?php

namespace App\models;

class ClanMember
{

    public int $userId;
    public int $clanId;
    public string $name;

    public function __construct(int $userId, int $clanId, string $name)
    {
        $this->userId = $userId;
        $this->clanId = $clanId;
        $this->name = $name;
    }
}
