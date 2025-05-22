<?php
ob_start();
require_once '../../vendor/autoload.php';
session_start();

use App\core\Context;

if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$unitId = (int)$_GET['id'];
$userId = $_SESSION['user']->id;

$result = Context::getInstance()->unitController->completeUnit($userId, $unitId);
if ($result) {
    $_SESSION['queue'] = array_filter($_SESSION['queue'], function ($item) use ($unitId) {
        return $item->id != $unitId;
    });
}
