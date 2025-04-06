<?php

namespace App\services;

use App\repositories\UnitRepository;

class UnitService
{
    private UnitRepository $unitRepository;
    public function __construct(UnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }
    public function getUnits(int $userId): array
    {
        return $this->unitRepository->getUnits($userId);
    }
}
