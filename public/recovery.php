<?php
require_once '../vendor/autoload.php';

use App\core\Context;
use Random\RandomException;
if (!isset($_GET['token'])) {
    header("Location: ../recover.php");
    exit;
}
$token = $_GET['token'];
include './includes/header.php';
?>
    <h2 class="text-3xl font-bold">Create new password</h2>


    <form action="recovery.php" method="post" class="bg-white p-6 rounded shadow-md w-1/2">

        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <label class="block mb-2" for="password">New password:</label>
        <input type="password" id="password" name="password" class="border p-2 w-full mb-4" required>

        <label class="block mb-2" for="repeat">Repeat password:</label>
        <input type="password" id="repeat" name="repeat" class="border p-2 w-full mb-4" required>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Change password</button>

<?php echo "<p class=" . "text-lg mt-4" . ">";
Context::getInstance()->userController->recoverPassword();
echo "</form>";
include './includes/footer.php';
