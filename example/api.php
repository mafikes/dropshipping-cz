<?php
/**
 * Example file communication with Dropshipping.cz
 * Doc: https://client.api.dropshipping.cz/
 */

require_once __DIR__ . '/../vendor/autoload.php';

$shopId = 8842; // your eshop id from dropshipping.cz

// Client register
$client = new \Mafikes\DropshippingCz\Client('$1$Ow30RQqf$wkWH80qhVjJe5yL/LZ4i91');

// Manufacturers
$limit = 100;
$offset = 0;
do {
    $manufacturers = $client->fetchProductsManufacturers(['eshop_id' => $shopId, 'limit' => $limit, 'offset' => $offset]);

    foreach ($manufacturers->data as $manufacturer) {
        // update, insert to DB
        var_dump($manufacturer);
    }

    $offset += 100;
} while (count($manufacturers->data) !== 0);

// Categories
$limit = 100;
$offset = 0;
do {
    $categories = $client->fetchProductsCategories(['eshop_id' => $shopId, 'limit' => $limit, 'offset' => $offset]);

    foreach ($categories->data as $category) {
        // update, insert to DB
        var_dump($category);
    }

    $offset += 100;
} while (count($categories->data) !== 0);


// Products Parameters
$limit = 100;
$offset = 0;
do {
    $productParameters = $client->fetchProductsParameters(['eshop_id' => $shopId, 'limit' => $limit, 'offset' => $offset]);

    foreach ($productParameters->data as $parameter) {
        // insert, update product
        var_dump($parameter);
    }

    $offset += 100;
} while (count($productParameters->data) !== 0);

// Products
$limit = 100;
$offset = 0;
do {
    $products = $client->fetchProducts(['eshop_id' => $shopId, 'limit' => $limit, 'offset' => $offset]);

    foreach ($products->data as $product) {
        // insert, update product
        var_dump($product);
    }

    $offset += 100;
} while (count($products->data) !== 0);

// Payments
$payments = $client->fetchAllPayments(['eshop_id' => $shopId]);
foreach ($payments->data as $payment) {
    // insert, update
    var_dump($payment);
}

// Deliveries
$deliveries = $client->fetchAllDeliveries(['eshop_id' => $shopId]);
foreach ($deliveries->data as $delivery) {
    // insert, update deliveries
    var_dump($delivery);

    // DELIVERY PLACES
    if($delivery->has_place) {
        $limit = 100;
        $offset = 0;
        do {
            $deliveryPlaces = $client->fetchAllDeliveryPlaces(['delivery_id' => $delivery->id, 'limit' => $limit, 'offset' => $offset]);

            foreach ($deliveryPlaces->data as $place) {
                // update insert delivery places
                var_dump($place);
            }

            $offset += 100;
        } while (count($deliveryPlaces->data) !== 0);
    }
}

// Send Order
$order = $client->postNewOrder([
    'remote_id' => '123456789', // Unikátní identifikátor z Vašeho systému. Např. číslo objednávky. Použitím tohoto paremetru zamezíte vzniku duplicitních objednávek.
    'eshop_id' => $shopId, // ID vašeho obchodu
    'email' => 'jan.novak@gmail.com', // E-mail zákazníka
    'phone' => '777 777 777', // Telefon zákazníka
    'invoice_firstname' => 'Jan', // Fakturační jméno zákazníka
    'invoice_surname' => 'Novák', // Fakturační příjmení zákazníka
    'invoice_ic' => '123456', // Fakturační IČO zákazníka
    'invoice_dic' => '654321', // Fakturační DIČ zákazníka
    'invoice_company' => 'Jan Novak', // Fakturační společnost zákazníka
    'invoice_street' => 'Korunní 21', // Fakturační ulice zákazníka
    'invoice_city' => 'Praha 2', // Fakturační město zákazníka
    'invoice_zipcode' => '128 00', // Fakturační PSČ zákazníka
    'contact_like_invoice' => 0, // Doručovací adresa stejná jako fakturační (0 = NE; 1 = ANO)
    'contact_company' => 'Jan Novak', // Doručovací společnost zákazníka
    'contact_firstname' => 'Jana', // Doručovací jméno zákazníka
    'contact_surname' => 'Nováková', // Doručovací příjmení zákazníka
    'contact_street' => 'Vinohradská 47', // Doručovací ulice zákazníka
    'contact_city' => 'Praha 2"', // Doručovací město zákazníka
    'contact_zipcode' => '128 00', // Doručovací PSČ zákazníka
    'contact_ico' => '123456', // Doručovací IČO zákazníka
    'contact_dic' => '654321', // Doručovací DIČ zákazníka
    'note' => '', // Poznámka k objednávce
    'payment_id' => '', // ID aktivní platební metody partnera
    'payment_price_vat' => '', // Cena platební metody s DPH
    'delivery_id' => '', // ID aktivní doručovací metody partnera
    'delivery_place_id' => '', // 	ID odběrného místa (ze systému dropshipping.cz). Viz Doručovací metody - odběrné místa
    'delivery_place_ext_id' => null, // ID odběrného místa (z externí služby, například zasilkovna.cz).
    'delivery_price_vat' => '', // Cena doručovací metody s DPH
    'basket' => [
        [ // pole produktů v košíku
          'id' => 1,  // ID aktivního produktu dodavatele. Nepovinné, pokud je uveden kód produktu
          'code' => 'DS12345678', // Kód aktivního produktu dodavatele. Nepovinné, pokud je uvedeno ID produktu
          'price_retail_vat' => 123.00, // Cena produktu s DPH
          'quantity' => 3, // Počet kusů produktu
        ]
    ],
    'test' => 1 // Testovací objednávka. V případě označení objednávky jako testovací ("test": "1"), nebude objednávka předána dodavateli.
]);
var_dump($order);

// Order status
$order_status = $client->fetchAllOrdersStatuses();
var_dump($order_status);

// Fetch detail of orders
$limit = 100;
$offset = 0;
do {
    $orders = $client->fetchOrders(['eshop_id' => $shopId, 'limit' => $limit, 'offset' => $offset]); // you can add id order, sort, created_from, created_to

    foreach ($orders->data as $order) {
        // update, insert to DB
        var_dump($order);
    }

    $offset += 100;
} while (count($orders->data) !== 0);