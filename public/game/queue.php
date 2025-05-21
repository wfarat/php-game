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

<div class="container mx-auto p-6 grid grid-cols-3 gap-6">

<?php foreach ($queue as $unit) : ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $unit->name ?></h5>
            <p class="card-text"><?= $unit->count ?></p>
        <?php if ($unit->endsAt > new DateTime()) : ?>
        <p class="card-text">Ends at <?= $unit->endsAt->format('d/m/Y H:i') ?></p>
        <?php else : ?>
            <button onclick="complete(<?= $unit->unitId ?>)" class="btn btn-success">Complete</button>
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
