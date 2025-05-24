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
                    onclick="accept(<?= $application->clanId ?>, <?= $application->userId ?>)"
                    class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 rounded font-medium transition">
                    Accept
                </button>
        </div>
    </div>

<?php endforeach; ?>


<?php include './includes/footer.php'; ?>

<script>
    function accept(clanId, userId) {
        fetch('complete.php?clanId=' + clanId + '&userId=' + userId)
            .then(() => window.location.reload());
    }
</script>
