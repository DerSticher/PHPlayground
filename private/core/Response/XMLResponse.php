<?php

namespace core\Response;

/**
 * Response class to send XML responses.
 *
 * @todo Doesn't work with spaces in tag names...
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class XMLResponse extends ResponseAbstract
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
        //creating object of SimpleXMLElement
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><response></response>");

        //function call to convert array to xml
        $this->array_to_xml($this->response, $xml);

        header('Content-Type: application/xml; charset=utf-8');
        echo $xml->asXML();
        exit;
    }

    /**
     * @see  parent
     */
    public static function send($body, $code = 1)
    {
        $response = new XMLResponse($body, $code);
        $response->_send();
    }

    /**
     * converts an array into XML
     * Source: http://www.codexworld.com/convert-array-to-xml-in-php/
     * @param  array $array                         content that's supposed to be converted
     * @param  SimpleXMLElement &$xml_user_info     root xml object
     */
    public function array_to_xml(array $array, &$xml_user_info)
    {
        $this->cleanKeys($array);
        foreach ($array as $key => $value) {
            $keyname = "$key";

            if (is_numeric($key)) {
                $keyname = "item_$key";
            }

            if (is_array($value)) {
                $subnode = $xml_user_info->addChild($keyname);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_user_info->addChild($keyname, htmlspecialchars("$value"));
            }
        }
    }

    private function cleanKeys(&$data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_numeric($key)) {
                    continue;
                }

                $nkey = str_replace(' ', '_', $key);
                if ($key != $nkey) {
                    unset($data[$key]);
                    $data[$nkey] = $value; // $this->cleanKeys($value);
                }
            }
        }

        return $data;
    }
}
