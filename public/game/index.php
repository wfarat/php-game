<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
include './includes/header.php';
?>

<!-- ✅ Main Layout: Game Overview -->
<div class="container mx-auto p-6 grid grid-cols-3 gap-6">

<?php include './buildings.php'; ?>
<?php include './army.php'; ?>
    <!-- 📌 Right Panel: Clan & Messages -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h2 class="text-lg font-bold">🏆 Clan & Messages</h2>
        <a href="clan.php" class="block text-yellow-400 mt-2">View Clan</a>
        <a href="messages.php" class="block text-blue-400 mt-2">Inbox</a>
    </div>

</div>
<?php include './includes/footer.php'; ?>
