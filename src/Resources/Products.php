<?php

namespace Mafikes\DropshippingCz\Resources;

use Mafikes\DropshippingCz\Client;
use Mafikes\DropshippingCz\Resources\Interfaces\ProductsInterface;

/**
 * Class Products
 * All functions related for products
 * @package Mafikes\DropshippingCz
 */
class Products implements ProductsInterface
{
    /** @var Client The Client instance */
    private $client;

    /**
     * Products constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $productId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetch($productId)
    {
        return $this->client->askServer('products', array(
            'eshop_id' => $this->client->getEshopId(),
            'id' => $productId
        ));
    }

    /**
     * Fetch all products
     * @param array $parameters
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchAll($parameters = array())
    {
        $data = [];

        if(array_key_exists('limit', $parameters) && array_key_exists('offset', $parameters)) {
            $data = $this->client->askServer('products', array(
                'eshop_id' => $this->client->getEshopId(),
                'limit' => $parameters['limit'],
                'offset' => $parameters['offset']
            ));
        } else {
            $data = $this->client->askServerPagination('products', array(
                'eshop_id' => $this->client->getEshopId(),
            ));
        }

        return $data;
    }

    /**
     * @param $productIds
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchInventory($productIds)
    {
        if(!is_array($productIds)) throw new \Exception('Product IDs is not array.');

        return $this->client->request('POST','products/inventory', array(
            'ids' => $productIds
        ));
    }

    /**
     * Fetch all products categories
     * @param array $parameters
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchCategories($parameters = array())
    {
        $data = [];

        if(array_key_exists('limit', $parameters) && array_key_exists('offset', $parameters)) {
            $data = $this->client->askServer('products/categories', array(
                'eshop_id' => $this->client->getEshopId(),
                'limit' => $parameters['limit'],
                'offset' => $parameters['offset']
            ));
        } else {
            $data = $this->client->askServerPagination('products/categories', array(
                'eshop_id' => $this->client->getEshopId(),
            ));
        }

        return $data;
    }

    /**
     * Fetch manufacturers
     * @param array $parameters
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchManufacturers($parameters = array())
    {
        $data = [];

        if(array_key_exists('limit', $parameters) && array_key_exists('offset', $parameters)) {
            $data = $this->client->askServer('products/manufacturers', array(
                'eshop_id' => $this->client->getEshopId(),
                'limit' => $parameters['limit'],
                'offset' => $parameters['offset']
            ));
        } else {
            $data = $this->client->askServerPagination('products/manufacturers', array(
                'eshop_id' => $this->client->getEshopId(),
            ));
        }

        return $data;
    }

    /**
     * Fetch all products parameters
     * @param array $parameters
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchParameters($parameters = array())
    {
        $data = [];

        if(array_key_exists('limit', $parameters) && array_key_exists('offset', $parameters)) {
            $data = $this->client->askServer('products/parameters', array(
                'eshop_id' => $this->client->getEshopId(),
                'limit' => $parameters['limit'],
                'offset' => $parameters['offset']
            ));
        } else {
            $data = $this->client->askServerPagination('products/parameters', array(
                'eshop_id' => $this->client->getEshopId(),
            ));
        }

        return $data;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchXmlCollection()
    {
        return $this->client->askServer('products/xml-collections');
    }
}

