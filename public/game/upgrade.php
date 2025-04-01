<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();

use App\core\Context;
use App\helpers\ProductionCalculator;

$data = json_decode(file_get_contents('php://input'), true);
$buildings = $_SESSION['buildings'];
$resources = Context::getInstance()->resourcesController->produceResources($buildings);
$id = Context::getInstance()->buildingController->upgradeBuilding($data, $resources);
if ($id > 0) {
    $user = $_SESSION['user'];
    Context::getInstance()->resourcesController->updateResources($user->id);
    foreach ($buildings as $building) {
        if ($building->building_id == $id) {
            $building->update();
        }
    }
    $_SESSION['production']->update(ProductionCalculator::countProduction($buildings));
}

ob_end_flush();
session_write_close();
