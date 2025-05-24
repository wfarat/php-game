<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
include './includes/header.php';
use App\core\Context;

$battles = Context::getInstance()->battleController->getBattles($_SESSION['user']->id);
$users = Context::getInstance()->userController->getUsers();
 if (!empty($battles)):
 foreach($battles as $battle): ?>
    <div class="bg-gray-800 p-4 rounded shadow-md mb-6 max-w-md mx-auto">
        <h2 class="text-xl font-semibold mb-2">Most Recent Battle</h2>
        <?php
        $defender = array_find($users, function ($item) use ($battle) {
            return $item->id === $battle->defenderId;
        });
        ?>
        <p><strong>Opponent:</strong> <?= htmlspecialchars($defender->name ?? 'Unknown') ?></p>
        <p><strong>Result:</strong> <?= htmlspecialchars($battle->winnerId == $_SESSION['user']->id ? 'Won' : 'Lost') ?></p>
        <?php $resources = $battle->resourcesTaken;
        if (!$resources->isEmpty()):?><p><strong>Resources taken:</strong>
            <span id="wood">🌲 Wood: <?= $resources->wood ?></span>
            <span id="stone">⛏ Stone: <?= $resources->stone ?></span>
            <span id="gold">💰 Gold: <?= $resources->gold ?></span>
            <span id="food">🍞 Food: <?= $resources->food ?></span></p>
        <?php endif; ?>
    </div>
<?php endforeach; else: ?>
    <div class="bg-gray-800 p-4 rounded shadow-md mb-6 max-w-md mx-auto">
        <p>No battles found.</p>
    </div>
<?php endif; ?>
