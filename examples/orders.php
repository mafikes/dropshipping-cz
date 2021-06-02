<?php
require_once __DIR__ . '/../vendor/autoload.php';

use \Mafikes\DropshippingCz\Client;

// Client Register
$client = new Client('shopId', 'ApiToken');

// Get all orders
$client->orders->fetchAll();

// Search in orders by parameters
/**
 *  eshop_id => ID obchodu (pro zobrazení objednávek konkrétního obchodu)
 *  serial_number => Číslo objednávky
 *  sort => Řazení záznámů. Směr řazení se určuje znakem "-" před názvem proměnné ("sort=created" = "created ASC"; "sort=-created" = "created DESC"). Defaultní řazení je "id ASC".
 *  created_from => Určuje datum, od kterého se mají objednávky vyhledat. Formát yyyy-mm-dd (např. 2017-01-01).
 *  created_to => Určuje datum, do kterého se mají objednávky vyhledat. Formát yyyy-mm-dd (např. 2017-01-01).
 *  remote_id => ID objednávky z Vašeho systému
 **/
$client->orders->fetchAll(array(
    'created_from' => '2021-01-01'
));

// Update order data
$client->orders->edit(411737, array(
    'email' => 'jan.novak@gmail.com',
    'invoice_ico' => '123456',
    'invoice_dic' => '654321',
    'invoice_company' => 'Jan Novak s.r.o',
));

// Change order status
$client->orders->editStatus(411737, 1); // orderId, orderStatusId from fetchAllStatuses

// Cancel order
$client->orders->cancel(411737); // required parameter orderId

// Return detail information about order
$client->orders->fetch(411737); // required parameter orderId


// Return all available statuses of orders
$client->orders->fetchAllStatuses();

// Create new order
$this->client->orders->create(array(
    'remote_id' => '1234', // Unikátní identifikátor z Vašeho systému. Např. číslo objednávky. Použitím tohoto paremetru zamezíte vzniku duplicitních objednávek.
    'auto_resend' => 0, // Má se objednávka poslat dále ke zpracování nebo má čekat na Vaše potvrzení? Pokud nebude parametr uveden, objednávka bude vždy automaticky poslána ke zpracování. (0 = NE; 1 = ANO)
    'email' => 'jan.novak@gmail.com', // E-mail zákazníka
    'phone' => '777 777 777', // Telefon zákazníka
    // Fakturacni udaje
    'invoice_firstname' => 'Jan',
    'invoice_surname' => 'Novak',
    'invoice_ico' => '123456',
    'invoice_dic' => '654321',
    'invoice_company' => 'Jan Novak s.r.o',
    'invoice_street' => 'Koruni 21',
    'invoice_city' => 'Praha 2',
    'invoice_zipcode' => '12800',
    'contact_like_invoice' => 0, // Doručovací adresa stejná jako fakturační (0 = NE; 1 = ANO)
    // Kontaktni informace / dorucovani adresa
    'contact_firstname' => 'Jan',
    'contact_surname' => 'Novak',
    'contact_ico' => '123456',
    'contact_dic' => '654321',
    'contact_company' => 'Jan Novak s.r.o',
    'contact_street' => 'Koruni 21',
    'contact_city' => 'Praha 2',
    'contact_zipcode' => '12800',
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
), true); // true/false if it testing order
