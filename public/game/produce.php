<?php ob_start();
require_once '../../vendor/autoload.php';
use App\core\Context;
Context::getInstance()->resourcesController->produceResources();
