<?php
require_once '../vendor/autoload.php';


use App\core\Context;


include './includes/header.php';

Context::getInstance()->userController->verify();

include './includes/footer.php';
