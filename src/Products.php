<?php

namespace Mafikes\DropshippingCz;

/**
 * Class Products
 * All functions related for products
 * @package Mafikes\DropshippingCz
 */
class Products
{
    /** @var Client */
    private $client;

    /**
     * Products constructor.
     * @param Client $client
     */
    public function __construct(Client  $client)
    {
        $this->client = $client;
    }

    /**
     * Fetch all products from eshop
     * @param array $parameters
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchProducts(array $parameters)
    {
        return $this->client->askServer('products', $parameters);
    }

    /**
     * Fetch all products parameters
     * @param array $parameters
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchProductsParameters(array $parameters)
    {
        return $this->client->askServer('products/parameters', $parameters);
    }

    /**
     * Fetch all products categories
     * @param array $parameters
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchProductsCategories(array $parameters)
    {
        return $this->client->askServer('products/categories', $parameters);
    }

    /**
     * Fetch all products manufacturers
     * @param array $parameters
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchProductsManufacturers(array $parameters)
    {
        return $this->client->askServer('products/manufacturers', $parameters);
    }

}
