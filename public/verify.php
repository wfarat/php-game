<?php
require_once '../vendor/autoload.php';


use App\Context;



include './includes/header.php';

Context::getInstance()->registerController->verify();

include './includes/footer.php';
