<?php
require_once __DIR__ . '/../vendor/autoload.php';

use \Mafikes\DropshippingCz\Client;

// Client Register
$client = new Client('shopId', 'ApiToken');

// Fetch one detail product
$client->products->fetch(1715227); // Return detail product data

// Fetch products
$client->products->fetchAll(array('limit' => 100, 'offset' => 0)); // Return with custom pagination
$client->products->fetchAll();  // Return all manufacturers

// Fetch product inventory
$client->products->fetchInventory(array(1715227, 1715228));

// Fetch product categories
$client->products->fetchCategories(array('limit' => 100, 'offset' => 0)); // Return with custom pagination
$client->products->fetchCategories(); // Return all manufacturers

// Fetch product manufacturers
$client->products->fetchManufacturers(array('limit' => 100, 'offset' => 0)); // Return with custom pagination
$client->products->fetchManufacturers(); // Return all manufacturers

// Fetch product parameters
$client->products->fetchParameters(array('limit' => 100, 'offset' => 0)); // Return with custom pagination
$client->products->fetchParameters(); // Return all manufacturers

// Fetch XML Collection
$client->products->fetchXmlCollection();
