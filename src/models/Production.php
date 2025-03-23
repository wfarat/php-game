<?php

namespace App\models;

class Production
{
    public ProductionType $type;
    public int $amount;
    public ProductionKind $kind;

    public function __construct(ProductionType $type, int $amount, ProductionKind $kind)
    {
        $this->type = $type;
        $this->amount = $amount;
        $this->kind = $kind;
    }
}
