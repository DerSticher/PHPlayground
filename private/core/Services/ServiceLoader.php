<?php

namespace core\Services;

use core\LoaderAbstract;

/**
 * Simple loader to use services.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class ServiceLoader extends LoaderAbstract
{
    public function __construct()
    {
        $this->namespace = 'service';
    }
}
