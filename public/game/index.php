
<?php
require_once '../../vendor/autoload.php';
include './includes/header.php';
$user = $_SESSION['user'];
use App\Context;
$resources = Context::getInstance()->resourcesService->getResources($user->id);
$buildings = Context::getInstance()->buildingRepository->getBuildings($user->id);
$units = Context::getInstance()->unitRepository->getUnits($user->id);
?>

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
    <a href="logout.php" class="text-red-400">Logout</a>
</div>

<!-- ✅ Main Layout: Game Overview -->
<div class="container mx-auto p-6 grid grid-cols-3 gap-6">

    <!-- 📌 Left Panel: Buildings -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h2 class="text-lg font-bold">🏠 Buildings</h2>
        <?php foreach ($buildings as $building): ?>
            <div class="mt-2 flex justify-between">
                <span><?= $building['name'] ?> (Lvl <?= $building['level'] ?>)</span>
                <a href="upgrade.php?id=<?= $building['id'] ?>" class="text-green-400">Upgrade</a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- 📌 Middle Panel: Army & Actions -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h2 class="text-lg font-bold">⚔ Army</h2>
        <?php foreach ($units as $unit): ?>
            <div class="mt-2 flex justify-between">
                <span><?= $unit['name'] ?>: <?= $unit['count'] ?></span>
                <a href="train.php?unit=<?= $unit['unit_id'] ?>" class="text-blue-400">Train</a>
            </div>
        <?php endforeach; ?>

        <h2 class="text-lg font-bold mt-4">🌍 Actions</h2>
        <a href="attack.php" class="block text-red-400 mt-2">Attack Enemies</a>
    </div>

    <!-- 📌 Right Panel: Clan & Messages -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h2 class="text-lg font-bold">🏆 Clan & Messages</h2>
        <a href="clan.php" class="block text-yellow-400 mt-2">View Clan</a>
        <a href="messages.php" class="block text-blue-400 mt-2">Inbox</a>
    </div>

</div>
<?php include './includes/footer.php'; ?>
