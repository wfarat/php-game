<?php
require_once '../vendor/autoload.php';
use Random\RandomException;
use App\Context;
try {
    Context::getInstance()->registerController->register();
} catch (RandomException $e) {
    echo $e->getMessage();
}

include './includes/header.php'; ?>

<h2>Register</h2>
    <form action="register.php" method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Register</button>
    </form>


<?php include './includes/footer.php';
