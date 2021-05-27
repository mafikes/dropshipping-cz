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

    private $jsonResponse;

    /**
     * DropshippingCz constructor.
     * @param $eshopId
     * @param $token
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
            'base_uri' => self::API_URL
        ]);

        $this->jsonResponse = $jsonResponse;
        $this->products = new Resources\Products($this);
        $this->deliveries = new Resources\Deliveries($this);
        $this->payments = new Resources\Payments($this);
        $this->profile = new Resources\Profile($this);
        $this->orders = new Resources\Orders($this);
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

        $result = $response->getBody()->getContents();

        if($this->jsonResponse) {
            return $result;
        } else {
            return json_decode($result);
        }
    }

    /**
     * @param $method
     * @param $data
     * @return mixed
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function post($method, $data)
    {
        $header = $this->createHeader();
        $header['headers']['content-type'] = 'application/json';
        $header['body'] = json_encode($data);

        $response = $this->client->request('POST', $method, $header);
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
}
