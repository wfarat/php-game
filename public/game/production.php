<?php
require_once '../../vendor/autoload.php';
use App\core\Context;
session_start();
Context::getInstance()->resourcesController->produceResources();
session_write_close();
