<?php

use App\core\Context;
use App\models\Resources;

$resourceController = Context::getInstance()->resourcesController;
$user = $_SESSION['user'];
$resourceController->getResources($user->id);
$resources = $_SESSION['resources'];
$_SESSION['production'] = new Resources(0, 0, 0, 0);
$production = $_SESSION['production'];
?>
<div class="flex gap-4">
    <span id="wood">🌲 Wood: <?= $resources->wood ?></span>
    <span id="stone">⛏ Stone: <?= $resources->stone ?></span>
    <span id="gold">💰 Gold: <?= $resources->gold ?></span>
    <span id="food">🍞 Food: <?= $resources->food ?></span>
</div>
<script>
    function updateResources() {
        const foodProduction = <?= $production->food ?>;
        const woodProduction = <?= $production->wood ?>;
        const goldProduction = <?= $production->gold ?>;
        const stoneProduction = <?= $production->stone ?>;
        const food = document.getElementById("food");
        const stone = document.getElementById("stone");
        const gold = document.getElementById("gold");
        const wood = document.getElementById("wood");

        function incrementResource(element, productionRate) {
            let currentValue = parseInt(element.textContent.replace(/\D/g, ""), 10);
            element.textContent = element.textContent.replace(/\d+/, currentValue + productionRate);
        }

        setInterval(() => {
            incrementResource(food, foodProduction);
            incrementResource(wood, woodProduction);
            incrementResource(gold, goldProduction);
            incrementResource(stone, stoneProduction);
        }, 1000); // Every second
    }

    document.addEventListener("DOMContentLoaded", updateResources);
</script>
