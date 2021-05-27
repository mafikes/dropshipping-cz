<?php
use PHPUnit\Framework\TestCase;
use Mafikes\DropshippingCz\Client;

final class ClientTest extends TestCase
{
    private $client;

    const ESHOP_ID = "";
    const API_TOKEN = '';

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new Client(self::ESHOP_ID, self::API_TOKEN, true);
    }

    public function testProfileGetMe()
    {
        $this->assertJson($this->client->profile->getMe());
    }

    public function testFetchAllEshops()
    {
        $this->assertJson($this->client->fetchAllEshops());
    }

    public function testFetchAllPayments()
    {
        $this->assertJson($this->client->payments->fetchAll());
    }

    public function testFetchAllDeliveries()
    {
        $this->assertJson($this->client->deliveries->fetchAll());
    }

    public function testFetchAllDeliveryPlaces()
    {
        $this->assertJson($this->client->deliveries->fetchAllPlaces(10));
    }

    public function testProductsFetchAll()
    {
        $this->assertJson($this->client->products->fetchAll());
    }

    public function testProductsFetchXmlCollection()
    {
        $this->assertJson($this->client->products->fetchXmlCollection());
    }

    public function testProductsFetch()
    {
        $this->assertJson($this->client->products->fetch(1));
    }

    public function testProductsFetchCategories()
    {
        $this->assertJson($this->client->products->fetchCategories());
    }

    public function testProductsFetchManufacturers()
    {
        $this->assertJson($this->client->products->fetchManufacturers());
    }

    public function testProductsFetchInventory()
    {
        $this->assertJson($this->client->products->fetchInventory(1));
    }

    public function testProductsFetchParameters()
    {
        $this->assertJson($this->client->products->fetchParameters());
    }
}
