<?php

namespace core\Response;

/**
 * Base class for responses.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
abstract class ResponseAbstract
{
    /**
     * Send a response.
     * @param  mixed  $body body/message, can be a string or an array
     * @param  integer $code response code
     */
    abstract public static function send($body, $code);

    /**
     * Creates the response array.
     * @param  mixed  $body body/message, can be a string or an array
     * @param  integer $code response code
     * @return array        response array
     */
    protected function makeResponse($body = '', $code = 1)
    {
        return array(
            'code' => $code,
            'body' => $body,
        );
    }
}
