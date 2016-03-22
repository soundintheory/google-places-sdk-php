<?php

namespace Google\Api\Places;

use GuzzleHttp;

/**
 * Created by PhpStorm.
 * User: bendia
 * Date: 1/22/15
 * Time: 10:11 PM
 */
class PlacesApiClient
{
    /** @var GuzzleHttp\Client $client HTTP Client. */
    protected $client;

    /** @var string Base URL. */
    protected $baseUrl = 'https://maps.googleapis.com/maps/api/';

    /** @var string|null API key. */
    protected $key = null;

    /**
     * Creates the HTTP client.
     *
     * @param string $key API key.
     * @param bool $parse Flag indicating if the responses should be auto parsed or returned as arrays.
     */
    public function __construct($library = 'place',$key = null)
    {
        $this->baseUrl .= $library;
        $this->client = new GuzzleHttp\Client();
        $this->key = $key;
    }

    /**
     * Calls the api with the specified parameters.
     *
     * @param string $method
     * @param string $path
     * @param array $params
     * @return Psr\Http\Message\ResponseInterface
     */
    protected function callApi($method = 'GET', $path = '/', $params = array())
    {
        if (!isset($params['key']))
            $params['key'] = $this->key;


        if(strlen(urlencode ($path . '/json'.implode("&",$params))) > 2040){
            throw new \Exception("URL too Long");
        }else{
            return $this->client->request($method, $this->baseUrl . $path . '/json', array(
                'query' => $params,
                'verify'=>false
            ));
        }


    }

    /**
     * Magic method for calling any endpoint
     */
    public function __call($name, $args)
    {
        if($name == 'call')
            $name = "";
        $query = (is_array($args) && count($args) && is_array($args[0])) ? $args[0] : array();
        $response = $this->callApi('GET', empty($name)?"":"/$name", $query);

        return new PlacesApiResponse($response);
    }

}


