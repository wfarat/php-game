<?php
require_once '../../vendor/autoload.php';
session_start();

use App\core\Context;

if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$clanId = (int)$_GET['id'];
$userId = $_SESSION['user']->id;

Context::getInstance()->clanController->apply($userId, $clanId);
