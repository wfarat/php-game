<?php
require_once '../../vendor/autoload.php';
session_start();
use App\core\Context;

if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$attackerId = (int)$_GET['id'];
$defenderId = $_SESSION['user']->id;

Context::getInstance()->battleController->createBattle($attackerId, $defenderId);

session_write_close();
