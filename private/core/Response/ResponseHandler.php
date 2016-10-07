<?php

namespace core\Response;

use core\Util\Singleton;

/**
 * Handles the response action to send in the right encoding.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class ResponseHandler extends Singleton
{
    /**
     * The response object for this request.
     * @var object
     */
    private $responseClass;

    /**
     * Initializes the handler.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Chooses the response object.
     */
    public function init()
    {
        $this->responseClass = new JsonResponse;

        if (!function_exists('getallheaders')) {
            return;
        }

        $reqHeaders = \getallheaders();

        if (isset($reqHeaders['Accept'])) {
            switch ($reqHeaders) {
                case 'application/xml':
                    $this->responseClass = new XMLResponse;
                    break;
                case 'application/pdf':
                // TODO: Create pdf response and figure out how to restrict usage of it
                case 'application/json':
                default:
                    $this->responseClass = new XMLResponse;
                    // $this->responseClass = new JsonResponse;
                    break;
            }
        }
    }

    /**
     * Send the response.
     * @param  mixed $body response body, string or array
     */
    public function send($body)
    {
        $this->responseClass::send($body);
    }

    /**
     * Sends an error response with an http code.
     * @param  integer $code HTTP Response Code
     */
    public function sendError($code)
    {
        $failures = array(
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
        );

        if (isset($failures[$code])) {
            $this->responseClass::send($failures[$code], $code);
        } else {
            $this->responseClass::send($failures[500], 500);
        }
    }
}
