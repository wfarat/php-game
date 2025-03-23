<?php

namespace App\models;

enum ProductionType: string
{
    case Resource = "Resource";
    case Military = "Military";
    case Administrative = "Administrative";
}
