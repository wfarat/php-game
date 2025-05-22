<?php
session_start();

if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    http_response_code(403); // Forbidden
    exit('Unauthorized');
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit('Missing user ID');
}

$attackerId = (int)$_GET['id'];
$defenderId = $_SESSION['user']->id;

require_once '../../vendor/autoload.php';

use App\core\Context;

$result = Context::getInstance()->attackController->createBattle($attackerId, $defenderId);
