<?php

use App\core\Context;

$user = $_SESSION['user'];
Context::getInstance()->resourcesController->getResources($user->id);
$resources = $_SESSION['resources'];
$observer = Context::getInstance()->resourceObserver;
$observer->attach([$resources, 'update']); ?>
<div class="flex gap-4">
    <span>🌲 Wood: <?= $resources->wood ?></span>
    <span>⛏ Stone: <?= $resources->stone ?></span>
    <span>💰 Gold: <?= $resources->gold ?></span>
    <span>🍞 Food: <?= $resources->food ?></span>
</div>