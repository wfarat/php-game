<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();
include './includes/header.php';
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
$user = $_SESSION['user'];

use App\core\Context;

$units = Context::getInstance()->unitRepository->getUnits($user->id);
?>

<!-- ✅ Main Layout: Game Overview -->
<div class="container mx-auto p-6 grid grid-cols-3 gap-6">

<?php include './buildings.php'; ?>

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
<script>
    function startProduction() {
        setInterval(() => fetch("production.php"), 1000)
    }
    document.addEventListener("DOMContentLoaded", startProduction);
</script>
<?php include './includes/footer.php'; ?>
