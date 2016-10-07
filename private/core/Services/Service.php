<?php

namespace core\Services;

use core\Model\ModelLoader;
use core\Util\Singleton;

abstract class Service extends Singleton
{

    public function __construct()
    {
        $this->Other = ServiceLoader::getInstance();
        $this->Model = ModelLoader::getInstance();
    }

    public function setService($name, $service)
    {

    }
}
