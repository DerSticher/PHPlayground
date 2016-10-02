<?php

require_once '..' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'autoloader.php';
require_once '..' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'util.php';
require_once '..' . DS . 'private' . DS . 'config' . DS . 'core.php';
use core\Router;

$router = new Router();
$router->dispatch();
