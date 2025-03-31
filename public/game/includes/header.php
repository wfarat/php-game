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

