<?php

namespace core\Model;

use core\LoaderAbstract;

/**
 * Simple Loader for models.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class ModelLoader extends LoaderAbstract
{
    public function __construct()
    {
        $this->namespace = 'model';
    }

}
