<?php

namespace App\models;

use DateTime;

class QueueItem
{
    public int $id;
    public int $unitId;
    public int $userId;
    public int $count;
    public string $name;
    public DateTime $endsAt;

    /**
     * @param int $id
     * @param int $unitId
     * @param int $userId
     * @param int $count
     * @param string $name
     * @param DateTime $endsAt
     */
    public function __construct(int $id, int $unitId, int $userId, int $count, string $name, DateTime $endsAt)
    {
        $this->id = $id;
        $this->unitId = $unitId;
        $this->userId = $userId;
        $this->count = $count;
        $this->name = $name;
        $this->endsAt = $endsAt;
    }

}
