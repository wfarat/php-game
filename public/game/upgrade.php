<?php
require_once '../../vendor/autoload.php';
session_start();
use App\Context;
Context::getInstance()->buildingController->upgradeBuilding();
