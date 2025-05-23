<?php

use App\core\Context;

ob_start();
require_once '../../vendor/autoload.php';
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
include './includes/header.php';
$user = $_SESSION['user'];
$clan = Context::getInstance()->clanController->getClan($user->id);
$members = Context::getInstance()->clanController->getMembers($user->id);
?>

<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Clan Info Column -->
    <div class="bg-gray-800 text-white rounded-lg shadow-lg p-6">
        <img src="<?= htmlspecialchars($clan['img'] ?? 'default-clan.jpg') ?>" alt="Clan Image" class="w-full h-48 object-cover rounded-lg mb-4">
        <h2 class="text-2xl font-bold mb-2"><?= htmlspecialchars($clan['name']) ?></h2>
        <p class="text-sm text-gray-300 mb-4"><?= htmlspecialchars($clan['description']) ?></p>
        <p class="mb-1"><strong>Level:</strong> <?= (int)$clan['level'] ?></p>
        <p class="mb-1"><strong>Members:</strong> <?= (int)$clan['members_count'] ?></p>
        <p class="mb-1"><strong>Leader ID:</strong> <?= (int)$clan['leader_id'] ?></p>
    </div>

    <!-- Members and Actions Column -->
    <div class="bg-gray-800 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
        <div>
            <h3 class="text-xl font-semibold mb-4">Members</h3>
            <ul class="space-y-3">
                <?php foreach ($members as $member) : ?>
                    <li class="flex justify-between items-center bg-gray-700 p-3 rounded">
                        <span><?= htmlspecialchars($member['username']) ?> (ID: <?= (int)$member['user_id'] ?>)</span>
                        <?php if ($member['user_id'] !== $clan['leader_id']) : ?>
                            <form method="POST" action="kick_member.php" onsubmit="return confirm('Kick this member?');">
                                <input type="hidden" name="user_id" value="<?= (int)$member['user_id'] ?>">
                                <input type="hidden" name="clan_id" value="<?= (int)$clan['id'] ?>">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Kick</button>
                            </form>
                        <?php else : ?>
                            <span class="text-sm italic text-gray-400">Leader</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Applications Link -->
        <div class="mt-6">
            <a href="clan_applications.php?clan_id=<?= (int)$clan['id'] ?>"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-2 rounded transition">
                View Applications
            </a>
        </div>
    </div>
</div>
