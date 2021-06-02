<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \Mafikes\DropshippingCz\Client;

// Client Register
$client = new Client('shopId', 'ApiToken');

// Fetch all deliveries methods
$client->deliveries->fetchAll(); // Return all delivery methods
$client->deliveries->fetchAll('partnerId'); // or get all by partnerId;
$client->deliveries->fetchAllPlaces(10); // Fetch all delivery places by delivery methodId

// Fetch all payment methods
$client->payments->fetchAll();
$client->payments->fetchAll('partnerId'); // or get all by partnerId

// Fetch information about my profile
$client->profile->getMe();

// Fetch all created eshops
$client->fetchAllEshops();
