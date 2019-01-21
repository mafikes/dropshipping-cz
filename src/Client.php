<?php

namespace Mafikes\DropshippingCz;

use GuzzleHttp;

/**
 * API class for portal Dropshipping.cz
 * Documentation: https://client.api.dropshipping.cz/
 * Author: Martin Antoš, mafikes.cz
 */
class Client
{
    /**
     * Token key
     * @var $token
     */
    private $token;

    /** @var $client */
    private $client;

    /**
     * DropshippingCz constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->createConnection();
    }

    protected function createConnection()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'https://client.api.dropshipping.cz/v1/'
        ]);
    }

    /**
     * Create headers
     * @return array
     */
    protected function createHeaders()
    {
        $headers = [
            'headers' => [
                'Authorization' => $this->token
            ]
        ];

        return $headers;
    }

    /**
     * Fetch all your eshops in account
     * @return mixed
     */
    public function fetchAllEshops()
    {
        $response = $this->client->request('GET', 'eshops', $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all products from eshop
     * @param array $parameters
     * @return mixed
     */
    public function fetchProducts(array $parameters)
    {
        $response = $this->client->request('GET', 'products?' . http_build_query($parameters), $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all products parameters
     * @param array $parameters
     * @return mixed
     */
    public function fetchProductsParameters(array $parameters)
    {
        $response = $this->client->request('GET', 'products/parameters?' . http_build_query($parameters), $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all products categories
     * @param array $parameters
     * @return mixed
     */
    public function fetchProductsCategories(array $parameters)
    {
        $response = $this->client->request('GET', 'products/categories?' . http_build_query($parameters), $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all products manufacturers
     * @param array $parameters
     * @return mixed
     */
    public function fetchProductsManufacturers(array $parameters)
    {
        $response = $this->client->request('GET', 'products/manufacturers?' . http_build_query($parameters), $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all payments
     * @param array $parameters
     * @return mixed
     */
    public function fetchAllPayments(array $parameters)
    {
        $response = $this->client->request('GET', 'payments?' . http_build_query($parameters), $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all deliveries
     * @param array $parameters
     * @return mixed
     */
    public function fetchAllDeliveries(array $parameters)
    {
        $response = $this->client->request('GET', 'deliveries?' . http_build_query($parameters), $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function fetchAllDeliveryPlaces(array $parameters)
    {
        $response = $this->client->request('GET', 'delivery-places?' . http_build_query($parameters), $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all order statuses
     * @return mixed
     */
    public function fetchAllOrdersStatuses()
    {
        $response = $this->client->request('GET', 'order-statuses', $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Fetch all orders
     * @param array $parameters
     * @return mixed
     */
    public function fetchOrders(array $parameters)
    {
        $response = $this->client->request('GET', 'orders?' . http_build_query($parameters), $this->createHeaders());
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Post new order
     * @return mixed / insterted orders information
     */
    public function postNewOrder($data)
    {
        $headers = $this->createHeaders();
        $headers['headers']['content-type'] = 'application/json';
        $headers['body'] = json_encode($data);
        $response = $this->client->request('POST', 'orders', $headers);

        return json_decode($response->getBody()->getContents());
    }
}