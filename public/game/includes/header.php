<?php
require_once '../../vendor/autoload.php';
session_start();
use App\Context;

$user = $_SESSION['user'];
$resources = Context::getInstance()->resourcesService->getResources($user->id);
$observer = Context::getInstance()->resourceObserver;
$observer->attach([$resources, 'update']);
if (!isset($_SESSION['auth'])) {
    header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My PHP Site</title>
    <link href="/php-game/public/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
<div class="bg-gray-800 p-4 flex justify-between">
    <div>
        <span class="text-xl font-bold"><?= htmlspecialchars($user->login) ?></span>
    </div>
    <div class="flex gap-4">
        <span>🌲 Wood: <?= $resources->wood ?></span>
        <span>⛏ Stone: <?= $resources->stone ?></span>
        <span>💰 Gold: <?= $resources->gold ?></span>
        <span>🍞 Food: <?= $resources->food ?></span>
    </div>
    <a href="./logout.php" class="text-red-400">Logout</a>
</div>

