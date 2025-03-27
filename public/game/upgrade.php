<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();
use App\Context;

$id = Context::getInstance()->buildingController->upgradeBuilding();
if ($id > 0) {
    $buildings = $_SESSION['buildings'];
    foreach ($buildings as $building) {
        if ($building->building_id == $id) {
            $building->update();
        }
    }
    $_SESSION['buildings'] = $buildings;
}

session_write_close();
