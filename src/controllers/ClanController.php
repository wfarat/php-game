<?php

namespace App\controllers;

use App\services\ClanService;

class ClanController
{

    private ClanService $clanService;

    public function __construct(ClanService $clanService)
    {
        $this->clanService = $clanService;
    }

    public function apply($userId, int $clanId)
    {
        $this->clanService->createRequest($userId, $clanId);
    }

    public function accept($userId, int $clanId)
    {
        return $this->clanService->acceptRequest($userId, $clanId);
    }

    public function reject($userId, int $clanId)
    {
        return $this->clanService->rejectRequest($userId, $clanId);
    }

    public function leave($userId, int $clanId) {
        return $this->clanService->leaveClan($userId, $clanId);
    }

    public function delete(int $clanId) {
        return $this->clanService->deleteClan($clanId);
    }

    public function getRequests(int $clanId) {
        return $this->clanService->getRequests($clanId);
    }

    public function getMembers(int $clanId) {
        return $this->clanService->getMembers($clanId);
    }

    public function getClan(int $clanId) {
        return $this->clanService->getClan($clanId);
    }

    public function getClans() {
        return $this->clanService->getClans();
    }

}
