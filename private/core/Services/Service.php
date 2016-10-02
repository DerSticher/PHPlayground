<?php

namespace core\Services;

abstract class Service
{
    protected $Other;

    public function __construct()
    {
        $this->Other = ServiceLoader::getInstance();
    }
}
