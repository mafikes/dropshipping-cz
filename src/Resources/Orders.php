<?php

namespace Mafikes\DropshippingCz\Resources;

use Mafikes\DropshippingCz\Client;
use Mafikes\DropshippingCz\Resources\Interfaces\OrdersInterface;

/**
 * Class Products
 * All functions related for products
 * @package Mafikes\DropshippingCz
 */
class Orders implements OrdersInterface
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
     * Fetch order by ID
     * @param $orderId
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetch($orderId)
    {
        return $this->client->askServer('orders', array(
            'eshop_id' => $this->client->getEshopId(),
            'id' => $orderId
        ));
    }

    /***
     * @param $parameters
     *      serial_number
     *      sort => Řazení záznámů. Směr řazení se určuje znakem "-" před názvem proměnné ("sort=created" = "created ASC"; "sort=-created" = "created DESC"). Defaultní řazení je "id ASC".
     *      created_from
     *      created_to
     *      remote_id => ID objednávky z Vašeho systému
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchAll($parameters = array())
    {
        // Remove single search
        if(key_exists('id', $parameters)) unset($parameters['id']);

        return $this->client->askServerPagination('orders', $parameters);
    }

    /**
     * Create new order
     * @param $data
     * @param bool $test
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($data, $test = true)
    {
        $data['eshop_id'] = $this->client->getEshopId();
        $data['test'] = $test;

        return $this->client->request('POST','orders', $data);
    }

    /**
     * Edit order
     * @param $orderId
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function edit($orderId, $data)
    {
        return $this->client->request('PUT','orders?id='.$orderId, $data);
    }

    /**
     * Change order status
     * @param $orderId
     * @param $statusId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function editStatus($orderId, $statusId)
    {
        return $this->client->request('PATCH','orders?id='.$orderId, array(
            'status_id' => $statusId
        ));
    }

    /**
     * Cancel order
     * @param $orderId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancel($orderId)
    {
        return $this->client->request('DELETE','orders?id='.$orderId, array());
    }

    /**
     * All existing statuses of orders
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchAllStatuses()
    {
        return $this->client->askServer('order-statuses');
    }
}

