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
     * Fetch all products from eshop
     * @param int $limit
     * @param int $offset
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchAll($limit = 30, $offset = 0)
    {
        return $this->client->askServer('products', array(
            'eshop_id' => $this->client->getEshopId(),
            'limit' => $limit,
            'offset' => $offset
        ));
    }

    /**
     * @param array $productIds
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchInventory($productIds)
    {
        return $this->client->askServer('products/inventory', array(
            'ids' => $productIds
        ));
    }

    /**
     * Fetch all products categories
     * @param null $limit => If it is null, returing all data
     * @param int $offset
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchCategories($limit = null, $offset = 0)
    {
        $parameters = array(
            'eshop_id' => $this->client->getEshopId()
        );

        if (!is_null($limit)) {
            $parameters = array_merge(array(
                'limit' => $limit,
                'offset' => $offset
            ), $parameters);
        }

        return $this->client->askServer('products/categories', $parameters);
    }

    /**
     * Fetch manufacturers
     * @param int $limit
     * @param int $offset
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchManufacturers($limit = 30, $offset = 0)
    {
        return $this->client->askServer('products/manufacturers', array(
            'eshop_id' => $this->client->getEshopId(),
            'limit' => $limit,
            'offset' => $offset
        ));
    }

    /**
     * Fetch all products parameters
     * @param int $limit
     * @param int $offset
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchParameters($limit = 30, $offset = 0)
    {
        return $this->client->askServer('products/parameters', array(
            'eshop_id' => $this->client->getEshopId(),
            'limit' => $limit,
            'offset' => $offset
        ));
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

