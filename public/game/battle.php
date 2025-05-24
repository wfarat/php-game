<?php
require_once '../../vendor/autoload.php';
session_start();
use App\core\Context;

if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$defenderId = (int)$_GET['id'];
$attackerId = $_SESSION['user']->id;
$buildings = $_SESSION['buildings'];
$resources = Context::getInstance()->resourcesController->produceResources($buildings);
try {
    $result = Context::getInstance()->battleController->createBattle($attackerId, $defenderId, $resources);
    if ($result) {
        Context::getInstance()->resourcesController->updateResources($attackerId);
    }
} catch (DateMalformedStringException $e) {
    error_log($e->getMessage());
}

session_write_close();
