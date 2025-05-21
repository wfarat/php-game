<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();

use App\core\Context;

$data = json_decode(file_get_contents('php://input'), true);
$buildings = $_SESSION['buildings'];
$context = Context::getInstance();
$resources = $context->resourcesController->produceResources($buildings);
$id = $context->unitController->trainUnits($data, $resources);
if ($id > 0) {
    $user = $_SESSION['user'];
    $context->resourcesController->updateResources($user->id);
}

ob_end_flush();
session_write_close();
