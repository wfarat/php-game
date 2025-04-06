<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();

use App\core\Context;

$data = json_decode(file_get_contents('php://input'), true);
$buildings = $_SESSION['buildings'];
$context = Context::getInstance();
$resources = $context->resourcesController->produceResources($buildings);
$id = $context->buildingController->upgradeBuilding($data, $resources);
if ($id > 0) {
    $user = $_SESSION['user'];
    $context->resourcesController->updateResources($user->id);
    foreach ($buildings as $building) {
        if ($building->building_id == $id) {
            $building->update();
        }
    }
    $_SESSION['production']->update($context->buildingService->countProduction($buildings));
}

ob_end_flush();
session_write_close();
