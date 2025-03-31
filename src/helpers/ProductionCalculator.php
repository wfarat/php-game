<?php

namespace App\helpers;

use App\models\ProductionKind;
use App\models\ProductionType;
use App\models\Resources;

class ProductionCalculator
{
    public static function countProduction(array $buildings): ?Resources
    {
        $wood = 0;
        $food = 0;
        $stone = 0;
        $gold = 0;
        foreach ($buildings as $building) {
            $production = $building->production;
            if ($production->type == ProductionType::Resource) {
                switch ($production->kind) {
                    case ProductionKind::Food:
                        $food += $production->amount;
                        break;
                    case ProductionKind::Gold:
                        $gold += $production->amount;
                        break;
                    case ProductionKind::Stone:
                        $stone += $production->amount;
                        break;
                    case ProductionKind::Wood:
                        $wood += $production->amount;
                        break;
                    default:
                }
            }
        }
        return new Resources($wood, $stone, $food, $gold);
    }
}