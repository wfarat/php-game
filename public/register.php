<?php
require_once '../vendor/autoload.php';

use Random\RandomException;
use App\Context;

include './includes/header.php';
?>
    <h2 class="text-3xl font-bold">Register</h2>


    <form action="register.php" method="post" class="bg-white p-6 rounded shadow-md w-1/2">
        <label class="block mb-2" for="login">Login:</label>
        <input type="text" id="login" name="login" class="border p-2 w-full mb-4" required>

        <label class="block mb-2" for="email">Email:</label>
        <input type="email" id="email" class="border p-2 w-full mb-4" name="email" required>

        <label class="block mb-2" for="password">Password:</label>
        <input type="password" id="password" name="password" class="border p-2 w-full mb-4" required>

        <label class="block mb-2" for="repeat">Password:</label>
        <input type="password" id="repeat" name="repeat" class="border p-2 w-full mb-4" required>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Register</button>

<?php echo "<p class=" . "text-lg mt-4" . ">";
try {
    Context::getInstance()->registerController->register();
} catch (RandomException $e) {
    echo $e->getMessage();
}
echo "</p>";
echo "</form>";
include './includes/footer.php';
