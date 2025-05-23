<?php
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My PHP Site</title>
    <link href="/public/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
<div class="bg-gray-800 p-4 flex justify-between">
    <div>
        <span class="text-xl font-bold"><?= htmlspecialchars($user->login) ?></span>
    </div>
    <?php include './includes/resources.php' ?>
    <a href="./logout.php" class="text-red-400">Logout</a>
</div>
<!-- Navigation Menu -->
<nav class="bg-gray-700 text-white p-3 shadow-md">
    <div class="flex justify-between p-4 text-lg font-medium">
        <span><a href="./index.php" class="hover:text-blue-400 transition">Home</a></span>
        <span><a href="./attack.php" class="hover:text-blue-400 transition">Attack</a></span>
        <span><a href="./queue.php" class="hover:text-blue-400 transition">Queue</a></span>
        <span><a href="./clan.php" class="hover:text-blue-400 transition">Clan</a></span>
        <span><a href="./messages.php" class="hover:text-blue-400 transition">Messages</a></span>
    </div>
</nav>
