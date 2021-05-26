<?php

namespace Mafikes\DropshippingCz;

use GuzzleHttp;

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

    /** @var $client */
    protected $client;

    /** @var Products */
    public $products;

    /**
     * DropshippingCz constructor.
     * @param $token
     * @throws \Exception
     */
    public function __construct($token)
    {
        if (is_string($token)) {
            $this->token = $token;
        } else {
            throw new \Exception('API key is not specify right.');
        }

        $this->client = new GuzzleHttp\Client([
            'base_uri' => self::API_URL
        ]);

        $this->products = new Products($this);
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
     */
    public function askServer(string $method, array $parameters = [])
    {
        $uri = $method;

        // Add params if exist
        if(count($parameters) > 0) $uri = $method. '?' . http_build_query($parameters);

        // Create request
        $response = $this->client->request('GET', $uri, $this->createHeader());

        // Catch Error code from header
        if(!in_array($response->getStatusCode(), array(200, 201)) || is_null($response->getStatusCode())) {
            throw new \Exception('Request error. Body: ' . $response->getBody());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all your eshops in account
     */
    public function fetchAllEshops()
    {
        $response = $this->client->request('GET', 'eshops', $this->createHeader());
        return json_decode($response->getBody()->getContents());
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
     * Fetch all deliveries
     * @param array $parameters
     * @return mixed
     */
    public function fetchAllDeliveries(array $parameters)
    {
        $response = $this->client->request('GET', 'deliveries?' . http_build_query($parameters), $this->createHeader());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function fetchAllDeliveryPlaces(array $parameters)
    {
        $response = $this->client->request('GET', 'delivery-places?' . http_build_query($parameters), $this->createHeader());
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
