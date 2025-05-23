<?php
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
if ($result > 0) {
    $_SESSION['queue'] = array_filter($_SESSION['queue'], function ($item) use ($unitId) {
        return $item->unitId != $unitId;
    });
    foreach ($_SESSION['units'] as $key => $unit) {
        if ($unit->unitId == $unitId) {
            $unit->count += $result;
            break;
        }
    }
}
session_write_close();
