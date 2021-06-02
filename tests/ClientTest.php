<?php
use PHPUnit\Framework\TestCase;
use Mafikes\DropshippingCz\Client;

final class ClientTest extends TestCase
{
    private $client;

    const ESHOP_ID = "";
    const API_TOKEN = '';

    public function __construct($name = null, $data = [], $dataName = '')
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
        $this->assertJson($this->client->products->fetchInventory(array(1, 2)));
    }

    public function testProductsFetchParameters()
    {
        $this->assertJson($this->client->products->fetchParameters());
    }

    public function testOrdersFetchAllStatuses()
    {
        $this->assertJson($this->client->orders->fetchAllStatuses());
    }

    public function testOrdersFetchAll()
    {
        // All orders without filter
        $this->assertJson($this->client->orders->fetchAll(10, 0));

        // Orders with filter
        $this->assertJson($this->client->orders->fetchAll(10, 0, array('created_from' => '1.1.2018')));
    }

    public function testOrderProcess()
    {
        $newOrder = $this->client->orders->create(array(
            'remote_id' => uniqId(), // Unikátní identifikátor z Vašeho systému. Např. číslo objednávky. Použitím tohoto paremetru zamezíte vzniku duplicitních objednávek.
            'auto_resend' => 0, // Má se objednávka poslat dále ke zpracování nebo má čekat na Vaše potvrzení? Pokud nebude parametr uveden, objednávka bude vždy automaticky poslána ke zpracování. (0 = NE; 1 = ANO)
            'email' => 'jan.novak@gmail.com', // E-mail zákazníka
            'phone' => '777 777 777', // Telefon zákazníka
            // Fakturacni udaje
            'invoice' => array(
                'firstname' => 'Jan',
                'surname' => 'Novak',
                'ico' => '123456',
                'dic' => '654321',
                'company' => 'Jan Novak s.r.o',
                'street' => 'Koruni 21',
                'city' => 'Praha 2',
                'zipcode' => '12800',
            ),
            'contact_like_invoice' => 0, // Doručovací adresa stejná jako fakturační (0 = NE; 1 = ANO)
            // Kontaktni informace / dorucovani adresa
            'contact' => array(
                'firstname' => 'Jan',
                'surname' => 'Novak',
                'ico' => '123456',
                'dic' => '654321',
                'company' => 'Jan Novak s.r.o',
                'street' => 'Koruni 21',
                'city' => 'Praha 2',
                'zipcode' => '12800',
            ),
            'zpl_note' => '', // Poznámka na balik
            'note' => '', // Poznámka k objednávce
            'payment_id' => '', // ID aktivní platební metody partnera
            'payment_price_vat' => '', // Cena platební metody s DPH
            'delivery_id' => '', // ID aktivní doručovací metody partnera
            'delivery_place_id' => '1', // 	ID odběrného místa (ze systému dropshipping.cz). Viz Doručovací metody - odběrné místa
            'delivery_place_ext_id' => null, // ID odběrného místa (z externí služby, například zasilkovna.cz).
            'delivery_price_vat' => '', // Cena doručovací metody s DPH
            'basket' => array(
                array( // pole produktů v košíku
                    'code' => 'DS54535757', // Kód aktivního produktu dodavatele. Nepovinné, pokud je uvedeno ID produktu
                    'price_retail_vat' => 123.00, // Cena produktu s DPH
                    'quantity' => 3, // Počet kusů produktu
                )
            )
        ), true);

        $this->assertJson($newOrder);

        $newOrder = json_decode($newOrder);

        // Change Order Items
        $this->assertJson($this->client->orders->edit($newOrder->id, array(
            'basket' => array(
                array(
                    'code' => 'DS83552668',
                    'price_retail_vat' => 123.00,
                    'quantity' => 1,
                ),
                array(
                    'code' => 'DS32837596',
                    'price_retail_vat' => 200.00,
                    'quantity' => 2,
                )
            ))
        ));

        // Change Order Status
        $this->assertJson($this->client->orders->editStatus($newOrder->id, 1));

        // Cancel Order
        $this->assertJson($this->client->orders->cancel($newOrder->id));
    }
}
