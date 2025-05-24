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
$applications = Context::getInstance()->clanController->getRequests($clan->id);
?>

<?php foreach ($applications as $application) : ?>

    <div class="bg-gray-700 text-white rounded-lg shadow-md p-4 flex flex-col justify-between">
        <div>
            <h5 class="text-xl font-semibold mb-2"><?= htmlspecialchars($application->name) ?></h5>
                <button
                    onclick="complete(<?= $application->clanId ?>, <?= $application->userId ?>)"
                    class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 rounded font-medium transition">
                    Complete
                </button>
        </div>
    </div>

<?php endforeach; ?>
