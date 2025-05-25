<?php use App\core\Context;

ob_start();
require_once '../../vendor/autoload.php';
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}
include './includes/header.php';
$clans = Context::getInstance()->clanController->getClans();
?>
<h1 class="text-3xl font-bold mb-6">Create a New Clan</h1>
<form action="create_clan.php" method="POST" class="bg-gray-800 text-white p-6 rounded-lg shadow-md mb-10 max-w-xl mx-auto">
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium mb-1">Clan Name</label>
        <input type="text" name="name" id="name" required
               class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500">
    </div>
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium mb-1">Description</label>
        <textarea name="description" id="description" rows="3" required
                  class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
    </div>
    <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded transition">
        Create Clan
    </button>
</form>

<?php if (!empty($clans)): ?>
    <h1 class="text-3xl font-bold mb-6">Clans</h1>
    <div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($clans as $clan) : ?>
            <div class="bg-gray-700 text-white rounded-lg shadow-md p-4 flex flex-col justify-between">
                <div>
                    <h5 class="text-xl font-semibold mb-2"><?= htmlspecialchars($clan->name) ?></h5>
                    <p class="mb-2">Count: <?= htmlspecialchars($clan->members_count) ?></p>
                        <button
                            onclick="apply(<?= $clan->id ?>)"
                            class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 rounded font-medium transition">
                            Apply
                        </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php include './includes/footer.php'; ?>

    <script>
        function apply(id) {
            fetch('apply.php?id=' + id);
        }
    </script>
