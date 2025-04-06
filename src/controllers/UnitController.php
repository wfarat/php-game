<?php

namespace App\controllers;

use App\services\UnitService;

class UnitController
{
    private UnitService $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function getUnits(int $userId): array
    {
        if (!isset($_SESSION['units'])) {
            $_SESSION['units'] = $unitService->getUnits($userId);
        }
        return $_SESSION['units'];
    }
}
