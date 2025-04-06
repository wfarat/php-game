<?php
$user = $_SESSION['user'];

use App\core\Context;

$units = Context::getInstance()->unitController->getUnits($user->id);
?>
    <!-- 📌 Middle Panel: Army & Actions -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h2 class="text-lg font-bold">⚔ Army</h2>
        <?php foreach ($units as $unit): ?>
            <div class="mt-2 flex justify-between">
                <span><?= $unit->name ?>: <?= $unit->count ?></span>
                <a href="train.php?unit=<?= $unit->unitId ?>" class="text-blue-400">Train</a>
            </div>
        <?php endforeach; ?>

        <h2 class="text-lg font-bold mt-4">🌍 Actions</h2>
        <a href="attack.php" class="block text-red-400 mt-2">Attack Enemies</a>
    </div>
