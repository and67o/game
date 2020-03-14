<?php

use Router\Router;

ini_set('display_errors', 1);
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$Router = new Router();
$Router->run();
