<?php

namespace core\Services;

use core\Model\ModelLoader;
use core\Util\Singleton;

/**
 * Base class for services. All services are singletons.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
abstract class Service extends Singleton
{
    /**
     * Grants access to all models and all other services.
     */
    public function __construct()
    {
        $this->Other = ServiceLoader::getInstance();
        $this->Model = ModelLoader::getInstance();
    }
}
