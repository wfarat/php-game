<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();

use App\core\Context;

Context::getInstance()->resourcesController->produceResources();

ob_end_flush();
session_write_close();