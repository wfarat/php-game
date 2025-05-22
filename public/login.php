<?php
require_once '../vendor/autoload.php';
session_start();

use App\core\Context;

include './includes/header.php';
?>
    <h2 class="text-3xl font-bold">Login</h2>


    <form action="login.php" method="post" class="bg-white p-6 rounded shadow-md w-1/2">
        <label class="block mb-2" for="login">Login:</label>
        <input type="text" id="login" name="login" class="border p-2 w-full mb-4" required>

        <label class="block mb-2" for="password">Password:</label>
        <input type="password" id="password" name="password" class="border p-2 w-full mb-4" required>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Login</button>
        <a href="recover.php" class="text-blue-500">Forgot password?</a>
<?php echo "<p class=" . "text-lg mt-4" . ">";
    Context::getInstance()->userController->login();

echo "</form>";
include './includes/footer.php';
