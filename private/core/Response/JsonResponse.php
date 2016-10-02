<?php

namespace core\Response;

/**
 * Response class to send json responses.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class JsonResponse extends ResponseAbstract
{
    /**
     * Response array
     * @var array
     */
    private $response;

    /**
     * Initializes the response.
     * @param mixed  $body body/message, can be a string or an array
     * @param integer $code response code
     */
    public function __construct($body = '', $code = 1)
    {
        $this->response = $this->makeResponse($body, $code);
    }

    /**
     * Sends the response. Exits afterwards.
     */
    protected function _send()
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->response);
        exit;
    }

    /**
     * @see  parent
     */
    public static function send($body, $code = 1)
    {
        $response = new JsonResponse($body);
        $response->_send();
    }
}
