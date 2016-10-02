<?php

namespace core\Api;

use core\LoaderAbstract;

/**
 * Simple Loader to load Api classes.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class ApiLoader extends LoaderAbstract
{
    public function __construct()
    {
        $this->namespace = 'api';
    }
}
