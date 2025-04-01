<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();

use App\core\Context;
use App\helpers\ProductionCalculator;

$data = json_decode(file_get_contents('php://input'), true);
$id = Context::getInstance()->buildingController->upgradeBuilding($data);
if ($id > 0) {
    $user = $_SESSION['user'];
    Context::getInstance()->resourcesController->updateResources($user->id);
    $buildings = $_SESSION['buildings'];
    foreach ($buildings as $building) {
        if ($building->building_id == $id) {
            $building->update();
        }
    }
    $_SESSION['production'] = ProductionCalculator::countProduction($buildings);
}

ob_end_flush();
session_write_close();
