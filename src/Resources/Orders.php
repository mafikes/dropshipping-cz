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

    /**
     * @param array $additionalParameters
     *  serial_number
     *  sort => Řazení záznámů. Směr řazení se určuje znakem "-" před názvem proměnné ("sort=created" = "created ASC"; "sort=-created" = "created DESC"). Defaultní řazení je "id ASC".
     *  created_from
     *  created_to
     *  remote_id => ID objednávky z Vašeho systému
     * @param $limit
     * @param $offset
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchAll($additionalParameters = array(), $limit, $offset)
    {
        $parameters = array(
            'eshop_id' => $this->client->getEshopId(),
            'limit' => $limit,
            'offset' => $offset
        );

        if(count($additionalParameters) > 0) {
            $parameters = array_merge($additionalParameters, $parameters);
        }

        if(key_exists('id', $parameters)) unset($parameters['id']);

        return $this->client->askServer('orders', $parameters);
    }

    /**
     * Create new order
     * @param $orderData
     * @param false $debug   Send as test order only
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($orderData, $test = false)
    {
        $orderData['test'] = $test;
        return $this->client->post('orders', $orderData);
    }

    public function edit($orderId, $data)
    {
        // TODO: Implement edit() method.
    }

    public function editStatus($orderId, $statusId)
    {
        // TODO: Implement editStatus() method.
    }

    public function delete($orderId)
    {
        // TODO: Implement delete() method.
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

