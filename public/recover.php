<?php
require_once '../vendor/autoload.php';
session_start();

use App\core\Context;
use Random\RandomException;

include './includes/header.php';
?>
    <h2 class="text-3xl font-bold">Recover Password</h2>


    <form action="recover.php" method="post" class="bg-white p-6 rounded shadow-md w-1/2">
        <label class="block mb-2" for="email">Email:</label>
        <input type="text" id="email" name="email" class="border p-2 w-full mb-4" required>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Send email</button>
<?php echo "<p class=" . "text-lg mt-4" . ">";
try {
    Context::getInstance()->userController->recover();
} catch (RandomException $e) {
    echo "Problem encountered when sending email.";
}

echo "</p>";
echo "</form>";
include './includes/footer.php';
