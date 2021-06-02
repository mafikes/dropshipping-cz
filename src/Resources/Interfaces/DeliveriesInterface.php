<?php

namespace Mafikes\DropshippingCz\Resources\Interfaces;

interface DeliveriesInterface
{
    public function fetchAll($partnerId);
    public function fetchAllPlaces($deliveryId);
}
