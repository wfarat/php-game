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
if (!$clan) {
    header("Location: ./clan_list.php");
    exit;
}
$members = Context::getInstance()->clanController->getMembers($clan->id);
?>

<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Clan Info Column -->
    <div class="bg-gray-800 text-white rounded-lg shadow-lg p-6">
        <img src="<?= htmlspecialchars('./upload/' . (empty($clan->img) ? 'default_clan.jpg' : $clan->img)) ?>" alt="Clan Image" class="w-full h-48 object-cover rounded-lg mb-4">
        <?php if ($user->id === $clan->leader_id): ?>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label>Select an image:</label>
            <input type="hidden" name="clanId" value='<?= $clan->id ?>'>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit" name="submit">Upload</button>
        </form>
        <?php endif; ?>
        <h2 class="text-2xl font-bold mb-2"><?= htmlspecialchars($clan->name) ?></h2>
        <p class="text-sm text-gray-300 mb-4"><?= htmlspecialchars($clan->description) ?></p>
        <p class="mb-1"><strong>Level:</strong> <?= $clan->level ?></p>
        <p class="mb-1"><strong>Members:</strong> <?= $clan->members_count ?></p>
        <p class="mb-1"><strong>Leader ID:</strong> <?= $clan->leader_id ?></p>
    </div>

    <!-- Members and Actions Column -->
    <div class="bg-gray-800 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
        <div>
            <h3 class="text-xl font-semibold mb-4">Members</h3>
            <ul class="space-y-3">
                <?php foreach ($members as $member) : ?>
                    <li class="flex justify-between items-center bg-gray-700 p-3 rounded">
                        <span><?= htmlspecialchars($member->name) ?> (ID: <?= $member->userId ?>)</span>
                        <?php if ($user->id === $clan->leader_id):
                             if ($member->userId !== $clan->leader_id): ?>
                            <form method="POST" action="kick_member.php" onsubmit="return confirm('Kick this member?');">
                                <input type="hidden" name="user_id" value="<?= $member->userId ?>">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Kick</button>
                            </form>
                        <?php else : ?>
                            <span class="text-sm italic text-gray-400">Leader</span>
                        <?php endif; endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="mt-6">
            <?php if ($user->id === $clan->leader_id): ?>
            <a href="clan_applications.php"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-2 rounded transition">
                View Applications
            </a>
            <button onclick="deleteClan()"
               class="inline-block bg-red-600 hover:bg-red-700 text-white text-center px-4 py-2 rounded transition">
                Delete Clan
            </button>
            <?php else : ?>
            <button onclick="leave()"
               class="inline-block bg-red-600 hover:bg-red-700 text-white text-center px-4 py-2 rounded transition">
                Leave clan
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    function deleteClan() {
        if (confirm('Are you sure you want to delete this clan?')) {
            fetch('delete_clan.php')
                .then(() => window.location.reload());
        }
    }
    function leave() {
        if (confirm('Are you sure you want to leave this clan?')) {
            fetch('leave_clan.php')
                .then(() => window.location.reload());        }
    }
</script>
