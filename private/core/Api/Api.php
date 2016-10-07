<?php

namespace core\Api;

use core\Model\ModelLoader;
use core\Response\ResponseHandler;
use core\Services\ServiceLoader;
use core\Util\Singleton;

/**
 * Api Baseclass. Every Api class MUST extend this class!
 * Provides the child classes with basic functionality such as services,
 * request parameters, and a Response Object.
 *
 * Note that the functions will behave just the same way, independent of http method and access type.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
abstract class Api extends Singleton
{
    /**
     * Response Object.
     * @var object
     */
    protected $Response;

    /**
     * Grants access to all services.
     * @var object
     */
    protected $Service;

    /**
     * Grants access to all models.
     * @var object
     */
    protected $Model;

    /**
     * Can be used to read config files.
     * @var object
     */
    protected $Config;

    /**
     * Request parameters.
     * @var array
     */
    protected $params;

    /**
     * Instantiates Api Helpers (ResponseHandler, ServiceLoader).
     */
    public function __construct()
    {
        $this->Response = ResponseHandler::getInstance();
        $this->Service = ServiceLoader::getInstance();
        $this->Model = ModelLoader::getInstance();
    }

    /**
     * Initializes the Api Object and inject the request params.
     * @param  array  $params request parameters
     */
    public function init(array $params)
    {
        $this->params = $params;
    }

    protected function render($name)
    {
        include __DIR__ . DS . '..' . DS . '..' . DS . '..' . DS . 'public' . DS . $name . '.html';
    }
}
