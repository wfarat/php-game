<?php ob_start();
require_once '../../vendor/autoload.php';
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
include './includes/header.php';
use App\core\Context;
$users = Context::getInstance()->userController->getUsers();
?>

<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($users as $user) : ?>
        <div class="bg-gray-700 text-white rounded-lg shadow-md p-4 flex flex-col justify-between">
            <div>
                <h5 class="text-xl font-semibold mb-2"><?= $user->login ?></h5>
                <p class="mb-2">Battles won: <?= $user->battlesWon ?></p>
                <button onclick="attack(<?= $user->id ?>)"
                        class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 rounded font-medium transition">Attack</button>
            </div>
        </div>
    <?php endforeach; ?>

</div>
<?php include './includes/footer.php'; ?>

<script>
    function attack(id) {
        fetch('battle.php?id=' + id);
    }
</script>
