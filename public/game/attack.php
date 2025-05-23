<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
include './includes/header.php';
use App\core\Context;
$users = Context::getInstance()->userController->getUsers();
$latestBattle = Context::getInstance()->battleController->getLatestBattle($_SESSION['user']->id);
?>
<?php if (!empty($latestBattle)): ?>
    <div class="bg-gray-800 p-4 rounded shadow-md mb-6 max-w-md mx-auto">
        <h2 class="text-xl font-semibold mb-2">Most Recent Battle</h2>
        <?php
        $defender = array_find($users, function ($item) use ($latestBattle) {
            return $item->id === $latestBattle->defenderId;
        });
        ?>
        <p><strong>Opponent:</strong> <?= htmlspecialchars($defender->name ?? 'Unknown') ?></p>
        <p><strong>Result:</strong> <?= htmlspecialchars($latestBattle->winnerId == $_SESSION['user']->id ? 'Won' : 'Lost') ?></p>
        <?php $resources = $latestBattle->resourcesTaken;
        if (!$resources->isEmpty()):?><p><strong>Resources taken:</strong>
            <span id="wood">🌲 Wood: <?= $resources->wood ?></span>
            <span id="stone">⛏ Stone: <?= $resources->stone ?></span>
            <span id="gold">💰 Gold: <?= $resources->gold ?></span>
            <span id="food">🍞 Food: <?= $resources->food ?></span></p>
        <?php endif; ?>
        <a href="./battles.php" class="mt-3 inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white font-medium transition">
            View All Battles
        </a>
    </div>
<?php else: ?>
    <div class="bg-gray-800 p-4 rounded shadow-md mb-6 max-w-md mx-auto">
        <p>No battles found.</p>
    </div>
<?php endif; ?>
<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($users as $user) : ?>
        <div class="bg-gray-700 text-white rounded-lg shadow-md p-4 flex flex-col justify-between">
            <div>
                <h5 class="text-xl font-semibold mb-2"><?= $user->name ?></h5>
                <p class="mb-2">Battles won: <?= $user->battlesWon ?></p>
                <button onclick="attack(<?= $user->id ?>)"
                        class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 rounded font-medium transition">Attack</button>
            </div>
        </div>
    <?php endforeach; ?>

</div>
<?php include './includes/footer.php'; ?>

<script>
    function attack(id) {
        fetch('battle.php?id=' + id).then(() => window.location.reload());
    }
</script>
