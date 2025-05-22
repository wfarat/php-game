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

<div class="container mx-auto p-6 grid grid-cols-3 gap-6">

    <?php foreach ($users as $user) : ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $user->login ?></h5>
                <p class="card-text">Battles won: <?= $user->battlesWon ?></p>
                <button onclick="attack(<?= $user->id ?>)" class="btn btn-success">Attack</button>
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
