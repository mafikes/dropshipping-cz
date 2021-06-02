<?php

namespace Mafikes\DropshippingCz;

use GuzzleHttp;
use Mafikes\DropshippingCz\Resources;

/**
 * API class for portal Dropshipping.cz
 * Documentation: https://client.api.dropshipping.cz/
 * Github: https://github.com/mafikes/dropshipping-cz
 * Author: Martin Antoš, mafikes.cz
 */
class Client
{
    const API_URL = 'https://client.api.dropshipping.cz/v1/';

    private $token;
    private $eshopId;
    private $client;

    /** @var Resources\Products */
    public $products;

    /** @var Resources\Deliveries */
    public $deliveries;

    /** @var Resources\Payments */
    public $payments;

    /** @var Resources\Profile */
    public $profile;

    /** @var Resources\Orders */
    public $orders;

    /** @var $jsonResponse */
    private $jsonResponse;

    /**
     * Client constructor.
     * @param $eshopId
     * @param $token
     * @param $timeout
     * @param false $jsonResponse
     * @throws \Exception
     */
    public function __construct($eshopId, $token, $jsonResponse = false)
    {
        if (is_string($token) || is_string($eshopId)) {
            $this->token = $token;
            $this->eshopId = $eshopId;
        } else {
            throw new \Exception('Dropshipping Class is not specify right (eshopId or token is not string).');
        }

        $this->client = new GuzzleHttp\Client([
            'base_uri' => self::API_URL,
            'allow_redirects' => true,
            'timeout' => 0,
        ]);

        $this->jsonResponse = $jsonResponse;
        $this->products = new Resources\Products($this);
        $this->deliveries = new Resources\Deliveries($this);
        $this->payments = new Resources\Payments($this);
        $this->profile = new Resources\Profile($this);
        $this->orders = new Resources\Orders($this);
    }

    /**
     * @param array $bodyData
     * @return array[]
     */
    public function createHeader($bodyData = array())
    {
        $header = array(
            'headers' => array(
                'Authorization' => $this->token,
                'content-type' => 'application/json'
            )
        );

        if(count($bodyData) > 0) {
            $header['body'] = json_encode($bodyData);
        }

        return $header;
    }

    /**
     * @param $uri
     * @param array $parameters
     * @param null $jsonResponse
     * @return array|mixed|string
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function askServer($uri, $parameters = array(), $jsonResponse = null)
    {
        // Add params if exist
        if (count($parameters) > 0) $uri = $uri . '?' . http_build_query($parameters);

        // Create request
        try {
            $response = $this->client->request('GET', $uri, $this->createHeader());
        } catch(GuzzleHttp\Exception\RequestException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }

        // Catch Error code from header
        if (!in_array($response->getStatusCode(), array(200, 201)) || is_null($response->getStatusCode())) {
            throw new \Exception('Exception: Request Error. Status: ' . $response->getStatusCode() . ' Body: ' . $response->getBody());
        }

        $result = $response->getBody()->getContents();

        if(!$this->jsonResponse || !is_null($jsonResponse) && $jsonResponse === false) {
            $result = json_decode($result, true);
            $result = array_key_exists('data', $result) ? $result['data'] : [];
        }

        return $result;
    }

    /**
     * Send request POST, PATCH or PUT
     * @param $method
     * @param $data
     * @return mixed
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri, $data = array())
    {
        $result = null;

        // Create request
        try {
            $response = $this->client->request($method, $uri, $this->createHeader($data));
            $result = $response->getBody()->getContents();

            // Catch Error code from header
            if (!in_array($response->getStatusCode(), array(200, 201)) || is_null($response->getStatusCode())) {
                throw new \Exception('Exception: Request Error. Status: ' . $response->getStatusCode() . ' Body: ' . $response->getBody());
            }

        } catch(GuzzleHttp\Exception\RequestException $e) {
            if ($e->getResponse()->getStatusCode() == '400') {
                $result = $e->getResponse()->getBody()->getContents();
            }
        } catch (\Exception $e) {
            throw new \Exception($e);
        }


        if(!$this->jsonResponse) {
            $result = json_decode($result, true);
            $result = array_key_exists('data', $result) ? $result['data'] : [];
        }

        return $result;
    }

    /**
     * Fetch all data with pagination
     * @param $uri
     * @param array $parameters
     * @return array
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function askServerPagination($uri, $parameters = array())
    {
        $resultData = [];

        $limit = 100;
        $offset = 0;

        do {
            $parameters['limit'] = $limit;
            $parameters['offset'] = $offset;

            $data = $this->askServer($uri, $parameters, false);
            $resultData = array_merge($resultData, $data);

            $offset += $limit;
        } while(count($data) !== 0);

        if($this->jsonResponse) $resultData = json_encode($resultData);

        return $resultData;
    }

    /**
     * @return string
     */
    public function getEshopId()
    {
        return $this->eshopId;
    }

    /**
     * Fetch all your eshops in account
     */
    public function fetchAllEshops()
    {
        return $this->askServer('eshops');
    }
}
