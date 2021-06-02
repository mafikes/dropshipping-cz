<?php

namespace Mafikes\DropshippingCz\Resources;

use Mafikes\DropshippingCz\Client;
use Mafikes\DropshippingCz\Resources\Interfaces\ProfileInterface;

/**
 * Class Profile
 * All functions related for products
 * @package Mafikes\DropshippingCz
 */
class Profile implements ProfileInterface
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

    public function getMe()
    {
        return $this->client->askServer('profile');
    }
}

