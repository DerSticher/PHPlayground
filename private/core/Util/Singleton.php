<?php

namespace core\Util;

/**
 * Abstract class that provides Singleton functionality.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
abstract class Singleton
{
    /**
     * All singleton instances.
     * @var array
     */
    private static $instances = array();

    /**
     * Empty constructor.
     */
    public function __construct()
    {}

    /**
     * Return an instance of the child object. If none exists yet, one is created.
     * @return object Child object instance.
     */
    public static function getInstance()
    {
        $class = get_called_class();

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }
}
