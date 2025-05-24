<?php
use App\core\Context;
require_once '../../vendor/autoload.php';
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
include './includes/header.php';
$user = $_SESSION['user'];
if ($user->role !== 'admin') {
    header("Location: ../login.php");
}
$targetId = (int)$_GET['id'];
$ban = (int)$_GET['ban'];
$context = Context::getInstance();
if ($ban > 0) {
    $context->userController->banUser($targetId);
} else {
    $context->userController->unbanUser($targetId);
}
header("Location: ./admin.php");
?>
