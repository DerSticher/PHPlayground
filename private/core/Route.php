<?php

namespace core;

/**
 * Basic route class.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class Route
{
    /**
     * Requested uri.
     * @var string
     */
    private $uri;

    /**
     * Requested http method.
     * @var string
     */
    private $method;

    /**
     * Requested api.
     * @var string
     */
    private $api;

    /**
     * Requested Api call.
     * @var string
     */
    private $call;

    /**
     * True if it should only be available on Dev servers.
     * @var boolean
     */
    private $devOnly;

    /**
     * True if a token is needed.
     * Not implemented yet.
     * @var boolean
     */
    private $tokenNeeded;

    /**
     * Initialized the object with all members.
     * @param string  $uri         Requested uri.
     * @param string  $method      HTTP METHOD
     * @param string  $api         Requested api.
     * @param string  $call        Requested api call.
     * @param boolean $devOnly     Dev-only?
     * @param boolean $tokenNeeded token needed?
     */
    public function __construct($uri, $method, $api, $call, $devOnly = false, $tokenNeeded = false)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->api = $api . 'Api';
        $this->call = $call;
        $this->devOnly = $devOnly;
        $this->tokenNeeded = $tokenNeeded;
    }

    /*
     * Getter start
     */

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getApi()
    {
        return $this->api;
    }

    public function getCall()
    {
        return $this->call;
    }

    public function getDevOnly()
    {
        return $this->devOnly;
    }

    public function getTokenNeeded()
    {
        return $this->tokenNeeded;
    }

    /*
     * Getter end
     */

    /*
     * Static functions
     */

    /**
     * Creates a route object from an array.
     * @param  string $key   key
     * @param  array  $array value
     * @return object        Route object
     */
    public static function getFromArray($key, array $array)
    {
        $uri = self::extractUri($key);
        $method = self::extractMethod($key);
        $api = self::extractApi($array['call']);
        $call = self::extractCall($array['call']);
        $devOnly = $array['dev_only'] ?? false;
        $tokenNeeded = $array['token_needed'] ?? false;
        return new Route($uri, $method, $api, $call, $devOnly, $tokenNeeded);
    }

    /**
     * Create a route object from a uri only.
     * Works fine, but currently not used.
     * @param  string $uri requested uri
     * @return object      Route object
     */
    public static function getFromDefault($uri)
    {
        $uri = self::extractUri($uri);
        $method = self::extractMethod($uri);

        $tmp = preg_replace('#^([a-zA-Z]*\s)#', '', $uri);
        $tmp = explode('/', $tmp);
        $api = $tmp[1];
        $call = $tmp[2];
        return new Route($uri, $method, $api, $call, false, false);
    }

    /**
     * Creates a route object from a simple pattern.
     * @param  string $key    key
     * @param  string $string value
     * @return object         Route object
     */
    public static function getFromSimple($key, $string)
    {
        $uri = self::extractUri($key);
        $method = self::extractMethod($key);
        $api = self::extractApi($string);
        $call = self::extractCall($string);
        return new Route($uri, $method, $api, $call, false, false);
    }

    /**
     * Extracts uri out of the key.
     * @param  string $key key
     * @return string      the uri
     */
    private static function extractUri($key)
    {
        $route = explode(' ', $key);

        if (count($route) == 1) {
            return $route[0];
        } else {
            return $route[1];
        }
    }

    /**
     * Extracts the method out of the key.
     * @param  string $key key
     * @return string      method
     */
    private static function extractMethod($key)
    {
        $route = explode(' ', $key);

        if (count($route) == 1) {
            return 'get';
        } else {
            return strtolower($route[0]);
        }
    }

    /**
     * Extracts the api out of the route.
     * @param  string $route route
     * @return string        api
     */
    private static function extractApi($route)
    {
        $route = explode('.', $route);
        return $route[0];
    }

    /**
     * Extracts the call out of the route.
     * @param  string $route route
     * @return string        route
     */
    private static function extractCall($route)
    {
        $route = explode('.', $route);
        return $route[1];
    }
}
