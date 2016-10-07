<?php

namespace core;

use core\Util\Singleton;

/**
 * Base class for all loaders.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
abstract class LoaderAbstract extends Singleton
{
    /**
     * Namespace from what it will create an object.
     * Must be set in the child class.
     * @var string
     */
    protected $namespace;

    /**
     * Magic method so loader can be used like this:
     * $Loader->foo->bar()
     * @param  string $name class name that is loaded from the namespace.
     * @return object       Requested Object.
     */
    public function __get($name)
    {
        $ns = '\\' . $this->namespace . '\\' . $name;

        if (method_exists($ns, 'getInstance')) {
            return call_user_func($ns . '::getInstance');
        }

        throw new \Exception("DAMN! THATS NO OBJECT, DUDE!", -1);
    }
}
