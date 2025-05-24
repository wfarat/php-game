<?php

require_once '../../vendor/autoload.php';

use App\models\Clan;
use App\core\Context;

session_start();

if (!isset($_SESSION['auth']) || !isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if ($name && $description) {

        Context::getInstance()->clanController->createClan($name, $description, $_SESSION['user']->id);
    }
}

header("Location: index.php");
exit;
