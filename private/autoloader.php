<?php

/**
 * Simple autoload function.
 * @param  string $class classname with namespace
 */
function _autoload($class)
{
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
}

// register autoloader
spl_autoload_register('_autoload');
