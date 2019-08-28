<?php

use Router\Router;

ini_set('display_errors', 1);
require_once 'vendor/autoload.php';

$Router = new Router();
$Router->run();
