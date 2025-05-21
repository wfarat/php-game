<?php
session_start();

if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    http_response_code(403); // Forbidden
    exit('Unauthorized');
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit('Missing unit ID');
}

$unitId = (int)$_GET['id'];
$userId = $_SESSION['user']->id;

require_once '../../vendor/autoload.php';

use App\core\Context;

$result = Context::getInstance()->unitController->completeUnit($userId, $unitId);
if ($result) {
    $_SESSION['queue'] = array_filter($_SESSION['queue'], function ($item) use ($unitId) {
        return $item->id != $unitId;
    });
}
