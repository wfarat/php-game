<?php

namespace App\services;

use App\repositories\ClanRepository;

class ClanService
{

    private ClanRepository $clanRepository;

    public function __construct(ClanRepository $clanRepository)
    {
        $this->clanRepository = $clanRepository;
    }

    public function createRequest($userId, int $clanId)
    {
    }

    public function acceptRequest($userId, int $clanId)
    {
    }

    public function rejectRequest($userId, int $clanId)
    {
    }

    public function leaveClan($userId, int $clanId)
    {
    }

    public function deleteClan(int $clanId)
    {
    }

    public function getRequests(int $clanId)
    {
    }

    public function getMembers(int $clanId)
    {
    }

    public function getClan(int $clanId)
    {
    }

    public function getClans()
    {
    }
}
