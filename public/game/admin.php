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
if ($user->role !== 'admin') {
    header("Location: ../login.php");
}
$users = Context::getInstance()->userController->getAllUsers();
?>
<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($users as $user) : ?>
        <div class="bg-gray-700 text-white rounded-lg shadow-md p-4 flex flex-col justify-between">
            <div>
                <h5 class="text-xl font-semibold mb-2"><?= htmlspecialchars($user->login) ?></h5>
                <p class="mb-2">Email: <?= htmlspecialchars($user->email) ?></p>
                <?php if (!$user->banned): ?>
                    <button
                            onclick="ban(<?= $user->id ?>)"
                            class="mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 rounded font-medium transition">
                        Ban
                    </button>
                <?php else: ?>
                    <button
                            onclick="ban(<?= $user->id ?>, 0)"
                            class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 rounded font-medium transition">
                        Unban
                    </button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function ban(id, ban = 1) {
        fetch('ban.php?id=' + id + '&ban=' + ban).then(() => window.location.reload());
    }
</script>
