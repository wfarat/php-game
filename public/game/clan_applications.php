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
if ($clan->leader_id !== $user->id) {
    header("Location: ./clan.php");
}
$applications = Context::getInstance()->clanController->getRequests($clan->id);
?>

<?php foreach ($applications as $application) : ?>

    <div class="bg-gray-700 text-white rounded-lg shadow-md p-4 flex flex-col justify-between">
        <div>
            <h5 class="text-xl font-semibold mb-2"><?= htmlspecialchars($application->name) ?></h5>
                <button
                    onclick="accept(<?= $application->userId ?>)"
                    class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 rounded font-medium transition">
                    Accept
                </button>
            <button
                    onclick="reject(<?= $application->userId ?>)"
                    class="mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 rounded font-medium transition">
                Accept
            </button>
        </div>
    </div>

<?php endforeach; ?>


<?php include './includes/footer.php'; ?>

<script>
    function accept(id) {
        fetch('accept.php?id' + id)
            .then(() => window.location.reload());
    }

    function reject(id) {
        fetch('reject.php?id' + id)
            .then(() => window.location.reload());
    }
</script>
