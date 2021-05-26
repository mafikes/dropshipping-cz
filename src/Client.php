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

    /** Token key*/
    private $token;

    /*** @var $eshopId */
    private $eshopId;

    /** @var $client */
    private $client;

    /** @var Resources\Products */
    public $products;

    /** @var Resources\Deliveries */
    public $deliveries;

    /**
     * DropshippingCz constructor.
     * @param $eshopId
     * @param $token
     * @throws \Exception
     */
    public function __construct($eshopId, $token)
    {
        if (is_string($token) || is_string($eshopId)) {
            $this->token = $token;
            $this->eshopId = $eshopId;
        } else {
            throw new \Exception('Dropshipping Class is not specify right (eshopId or token is not string).');
        }

        $this->client = new GuzzleHttp\Client([
            'base_uri' => self::API_URL
        ]);

        $this->products = new Resources\Products($this);
        $this->deliveries = new Resources\Deliveries($this);
    }

    /**
     * Create headers
     * @return array
     */
    public function createHeader()
    {
        return [
            'headers' => [
                'Authorization' => $this->token
            ]
        ];
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function askServer($method, array $parameters = array())
    {
        $uri = $method;

        // Add params if exist
        if (count($parameters) > 0) $uri = $method . '?' . http_build_query($parameters);

        // Create request
        try {
            $response = $this->client->request('GET', $uri, $this->createHeader());
        } catch(GuzzleHttp\Exception\RequestException $e) {
            throw new \Exception($e);
        }

        // Catch Error code from header
        if (!in_array($response->getStatusCode(), array(200, 201)) || is_null($response->getStatusCode())) {
            throw new \Exception('Exception: Request Error. Status: ' . $response->getStatusCode() . ' Body: ' . $response->getBody());
        }

        return json_decode($response->getBody()->getContents());
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

    /**
     * Fetch all payments
     * @param array $parameters
     * @return mixed
     */
    public function fetchAllPayments(array $parameters)
    {
        $response = $this->client->request('GET', 'payments?' . http_build_query($parameters), $this->createHeader());
        return json_decode($response->getBody()->getContents());
    }
    
    /**
     * Fetch all order statuses
     * @return mixed
     */
    public function fetchAllOrdersStatuses()
    {
        $response = $this->client->request('GET', 'order-statuses', $this->createHeader());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all orders
     * @param array $parameters
     * @return mixed
     */
    public function fetchOrders(array $parameters)
    {
        $response = $this->client->request('GET', 'orders?' . http_build_query($parameters), $this->createHeader());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Post new order
     * @return mixed / insterted orders information
     */
    public function postNewOrder($data)
    {
        $headers = $this->createHeader();
        $headers['headers']['content-type'] = 'application/json';
        $headers['body'] = json_encode($data);
        $response = $this->client->request('POST', 'orders', $headers);

        return json_decode($response->getBody()->getContents());
    }
}
