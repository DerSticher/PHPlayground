<?php

namespace core\Exceptions;

define('ROUTER_INVALID_URI', -1);
define('ROUTER_INVALID_ACTION_MISSING', -2);
define('ROUTER_INVALID_API_MISSING', -3);
define('ROUTER_INVALID_API_AVAILABLE', -4);
define('ROUTER_INVALID_ROUTE', -5);
define('ROUTER_INVALID_ROUTE_CONFIG', -6);

/**
 * Exception class for exceptions caused by the router.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class RouterException extends \Exception
{
    /**
     * Creates the Exception.
     * @param int $arg type of exception
     */
    public function __construct($arg)
    {
        switch ($arg) {
            case ROUTER_INVALID_URI:
                parent::__construct('invalid uri', -1);
                break;
            case ROUTER_INVALID_ACTION_MISSING:
                parent::__construct('no action', -2);
                break;
            case ROUTER_INVALID_API_MISSING:
                parent::__construct('no api', -3);
                break;
            case ROUTER_INVALID_API_AVAILABLE:
                parent::__construct('api unavailable', -4);
                break;
            case ROUTER_INVALID_ROUTE:
                parent::__construct('invalid request', -5);
                break;
            case ROUTER_INVALID_ROUTE_CONFIG:
                parent::__construct('invalid route configuration', -6);
                break;
            default:
                parent::__construct('unknown error', -99);
                break;
        }
    }

    /**
     * Returns exception information as an assoc array.
     * @return array exception information
     */
    public function toArray()
    {
        if (DEV) {
            return array(
                'code' => $this->code,
                'message' => $this->message,
                'file' => $this->file,
                'line' => $this->line,
            );
        }

        return array(
            'code' => $this->code,
            'message' => $this->message,
        );
    }
}
