<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link href="/php-game/public/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
<nav class="bg-blue-500 text-white p-4">
    <div class="container mx-auto">
        <a href="index.php" class="mr-4">Game</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>
<div class="container mx-auto p-4">
