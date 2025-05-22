<?php use App\core\Context;

ob_start();
require_once '../../vendor/autoload.php';
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}
include './includes/header.php';
$queue = Context::getInstance()->unitController->getQueue($_SESSION['user']->id);
?>

<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($queue as $unit) : ?>
        <div class="rounded-2xl shadow-md bg-white p-4 flex flex-col justify-between">
            <div>
                <h5 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($unit->name) ?></h5>
                <p class="text-gray-700 mb-2">Count: <?= htmlspecialchars($unit->count) ?></p>
                <?php if ($unit->endsAt > new DateTime()) : ?>
                    <p class="text-sm text-gray-500">Ends at <?= $unit->endsAt->format('d/m/Y H:i') ?></p>
                <?php else : ?>
                    <button
                            onclick="complete(<?= (int)$unit->unitId ?>)"
                            class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                        Complete
                    </button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include './includes/footer.php'; ?>

<script>
    function complete(id) {
        fetch('complete.php?id=' + id);
    }
</script>
