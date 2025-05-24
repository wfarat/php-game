<?php

namespace App\services;

use App\models\Clan;
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
        $this->clanRepository->createRequest($userId, $clanId);
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
        return $this->clanRepository->getMembers($clanId);
    }

    public function getClan(int $clanId): ?Clan
    {
        return $this->clanRepository->getById($clanId);
    }

    public function getClans()
    {
    }

    public function saveImage(string $name, int $clanId)
    {
        $this->clanRepository->saveImage($name, $clanId);
    }

    public function createClan(string $name, string $description, int $leaderId): false|string
    {
        return $this->clanRepository->create($name, $description, $leaderId);
    }
}
