<?php

namespace App\models;

use DateTime;

class Token
{
    public string $token;
    public string $type;
    public int $userId;
    public DateTime $createdAt;
    public DateTime $expiresAt;

    /**
     * @param string $type
     * @param string $token
     * @param int $userId
     * @param DateTime $createdAt
     * @param DateTime $expiresAt
     */
    public function __construct(string $token, string $type, int $userId, DateTime $createdAt, DateTime $expiresAt)
    {
        $this->token = $token;
        $this->type = $type;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
        $this->expiresAt = $expiresAt;
    }



}
