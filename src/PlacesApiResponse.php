<?php

namespace Google\Api\Places;

/**
 * Created by PhpStorm.
 * User: bendia
 * Date: 1/24/15
 * Time: 5:31 PM
 */
class PlacesApiResponse
{
    const STATUS_OK = 'OK';
    const STATUS_ZERO_RESULTS = 'ZERO_RESULTS';
    const STATUS_OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    const STATUS_REQUEST_DENIED = 'REQUEST_DENIED';
    const STATUS_INVALID_REQUEST = 'INVALID_REQUEST';

    /** @var array */
    protected $data;

    /**
     * @param $array
     */
    public function __construct($response)
    {
        $json = (string)$response->getBody();
        $this->data = (array)json_decode($json);
    }

    public function __isset($key)
    {
        if (is_array($this->data))
            return isset($this->data[$key]);

        return false;
    }

    public function __unset($key)
    {
        if (is_array($this->data) && isset($this->data[$key]))
            unset($this->data[$key]);
    }

    public function __set($key, $val)
    {
        if (is_array($this->data))
            $this->data[$key] = $val;
    }

    public function __get($key)
    {
        if (is_array($this->data))
            return isset($this->data[$key]) ? $this->data[$key] : null;

        return null;
    }

    /**
     * @return array HTML Attributions
     */
    public function getHtmlAttributions()
    {
        return $this->html_attributions;
    }

    /**
     * @return string Response status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string array data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return bool Flag indicating if the response status is equal to OK.
     */
    public function isOk()
    {
        return $this->getStatus() == static::STATUS_OK;
    }

    /**
     * @return bool Flag indicating if the response status is equal to ZERO_RESULTS.
     */
    public function isZeroResults()
    {
        return $this->getStatus() == static::STATUS_ZERO_RESULTS;
    }

    /**
     * @return bool Flag indicating if the response status is equal to OVER_QUERY_LIMIT.
     */
    public function isOverQueryLimit()
    {
        return $this->getStatus() == static::STATUS_OVER_QUERY_LIMIT;
    }

    /**
     * @return bool Flag indicating if the response status is equal to REQUEST_DENIED.
     */
    public function isRequestDenied()
    {
        return $this->getStatus() == static::STATUS_REQUEST_DENIED;
    }

    /**
     * @return bool Flag indicating if the response status is equal to INVALID_REQUEST.
     */
    public function isInvalidRequest()
    {
        return $this->getStatus() == static::STATUS_INVALID_REQUEST;
    }
}
