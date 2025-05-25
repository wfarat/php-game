<?php
use App\core\Context;
require_once '../../vendor/autoload.php';
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
include './includes/header.php';
$user = $_SESSION['user'];
$clan = Context::getInstance()->clanController->getClan($user->id);
if (!$clan) {
    header("Location: ./clan_list.php");
    exit;
}
if ($clan->leader_id !== $user->id) {
    header("Location: ./clan.php");
}

$userId = (int)$_GET['id'];

Context::getInstance()->clanController->accept($userId, $clan->id);
