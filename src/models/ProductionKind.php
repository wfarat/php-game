<?php

namespace App\models;

enum ProductionKind: string
{
    case Wood = "wood";
    case Stone = "stone";
    case Food = "food";
    case Gold = "gold";
    case Swordsman = "swordsman";
    case None = "none";
    case Archer = "archer";
    case Cavalry = "cavalry";
    case Catapult = "catapult";
}
