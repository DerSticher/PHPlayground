<?php

namespace core;

use core\Api\ApiLoader;
use core\Cache\ConfigCache;
use core\Exceptions\RouterException;
use core\Response\ResponseHandler;

/**
 * Generic Router class that dispatches the call according to the routing.json file.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class Router
{
    /**
     * Dispatches the call and execute the API method that is requested.
     * If no matching API method is found, it sends a 404 header.
     */
    public function dispatch()
    {
        try {
            // Request method
            $method = $this->getMethod();

            // Requested API
            $api = $this->getRequestApi();

            // Requested API call
            $call = $this->getRequestApiCall();

            $isValid = $this->validateCall($method, $api, $call);

            if ($isValid) {

            }
        } catch (RouterException $ex) {
            ResponseHandler::getInstance()->send($ex->toArray());
            ResponseHandler::getInstance()->sendError(400);
        }
    }

    /**
     * Reads the request method from globals
     * @return String HTTP method
     */
    private function getMethod()
    {
        $method = strtolower(filter_input(INPUT_SERVER, 'REQUEST_METHOD'));

        return $method;
    }

    /**
     * Reads the requested
     * @return [type] [description]
     */
    private function getURI()
    {
        $uri = strtok(filter_input(INPUT_SERVER, 'REQUEST_URI'), '?');
        return $uri;
    }

    /**
     * Reads the requested API's name.
     *
     * @return mixed
     * @throws RouterException
     */
    private function getRequestApi()
    {
        $uri = $this->getURI();

        if (empty($uri)) {
            throw new RouterException(ROUTER_INVALID_URI);
        }
        $input = array_filter(explode('/', $uri));

        if (!empty($input)) {
            return $input[1];
        } else {
            throw new RouterException(ROUTER_INVALID_API_MISSING);
        }
    }

    /**
     * Retrieves the method of the API called.
     * @return String API method
     */
    private function getRequestApiCall()
    {
        $uri = $this->getURI();

        if (empty($uri)) {
            throw new RouterException(ROUTER_INVALID_URI);
        }
        $input = array_filter(explode('/', $uri));

        if (isset($input[2])) {
            $input[2];
        } else {
            throw new RouterException(ROUTER_INVALID_ACTION_MISSING);
        }
    }

    /**
     * Evaluates if the call is supported.
     * @param  String $method HTTP Method
     * @param  String $api    API called
     * @param  String $call   API method called
     * @return boolean         whether or whether not the call is valid
     */
    private function validateCall($method, $api, $call)
    {
        $routes = ConfigCache::getInstance()->getConfig('routing');
        $uri = $this->getURI();
        $route = null;

        foreach ($routes as $key => $value) {
            if (is_int($key)) {
                $route = Route::getFromDefault($value);
            } elseif (is_string($value)) {
                $route = Route::getFromSimple($key, $value);
            } elseif (is_array($value)) {
                $route = Route::getFromArray($key, $value);
            } else {
                continue;
            }

            if ($route->getUri() == $uri && $route->getMethod() == $method) {
                break;
            } else {
                $route = null;
            }
        }

        if ($route == null) {
            throw new RouterException(ROUTER_INVALID_ROUTE);
        }

        if ($route->getDevOnly() && !DEV) {
            throw new RouterException(ROUTER_INVALID_ROUTE);
        }

        $params = $this->getParams($method);

        $api = $route->getApi();
        $call = $route->getCall();
        $class = ApiLoader::getInstance()->{$api};
        $class->init($params);
        $class->{$call}();
    }

    private function getParams($method)
    {
        $params = array();

        switch ($method) {
            case 'post':
                $params = $_POST;
                break;
            case 'put':
            case 'delete':
                parse_str(file_get_contents('php://input'), $params);
                break;
            case 'get':
            default:
                $params = $_GET;
                break;

        }
        return $params;
    }

}
