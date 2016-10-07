<?php

require_once __DIR__ . '/../private/autoloader.php';
require_once __DIR__ . '/../private/config/util.php';
require_once __DIR__ . '/../private/config/core.php';
use core\Router;

$router = new Router();
$router->dispatch();
