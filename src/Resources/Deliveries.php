<?php

namespace Mafikes\DropshippingCz\Resources;

use Mafikes\DropshippingCz\Client;
use Mafikes\DropshippingCz\Resources\Interfaces\DeliveriesInterface;

/**
 * Class Deliveries
 * All functions related for products
 * @package Mafikes\DropshippingCz
 */
class Deliveries implements DeliveriesInterface
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
     * All available deliveries
     * @param null $partnerId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchAll($partnerId = null)
    {
        $parameters = array(
            'eshop_id' => $this->client->getEshopId(),
        );

        if(!is_null($partnerId)) {
            $parameters = array(
                'partner_id' => $partnerId
            );
        }

        return $this->client->askServer('deliveries', $parameters);
    }

    /**
     * All avalaible places for delivery Id
     * @param $deliveryId
     * @param $limit
     * @param $offset
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchAllPlaces($deliveryId, $limit = 30, $offset = 0)
    {
        return $this->client->askServer('delivery-places', array(
            'delivery_id' => $deliveryId,
            'limit' => $limit,
            'offset' => $offset
        ));
    }
}

