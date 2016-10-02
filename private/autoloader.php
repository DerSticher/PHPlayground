<?php

function _autoload($class)
{
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('_autoload');
