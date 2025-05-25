<?php

namespace App\services;

use App\models\Clan;
use App\repositories\ClanRepository;
use PDOException;

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
        $this->clanRepository->removeRequest($userId, $clanId);
        $this->clanRepository->addMember($clanId, $userId);
    }

    public function rejectRequest($userId, int $clanId)
    {
        $this->clanRepository->removeRequest($userId, $clanId);
    }

    public function leaveClan($userId, int $clanId)
    {
        $this->clanRepository->removeMember($userId, $clanId);
    }

    public function deleteClan(int $clanId)
    {
        $this->clanRepository->delete($clanId);
    }

    public function getRequests(int $clanId)
    {
        return $this->clanRepository->getRequests($clanId);
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
        return $this->clanRepository->findAll();
    }

    public function saveImage(string $name, int $clanId)
    {
        $this->clanRepository->saveImage($name, $clanId);
    }

    public function createClan(string $name, string $description, int $leaderId): void
    {
        $id = $this->clanRepository->create($name, $description, $leaderId);
        $this->clanRepository->addMember($id, $leaderId);
    }

    public function kickMember($userId, int $clanId)
    {
        $this->clanRepository->removeMember($userId, $clanId);
    }
}
