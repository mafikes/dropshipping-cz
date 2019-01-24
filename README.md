About
------------
Library in php for communication with [Dropshipping.cz API](https://client.api.dropshipping.cz/).

Install
------------
```
composer require mafikes/dropshipping-cz
```

Example
------------
All examples is in example/api.php

#### Init Client
```php
$client = new \Mafikes\DropshippingCz\Client('Your token here');
```

#### Categories
```php
$client->fetchProductsCategories(['eshop_id' => 'your shop id', 'limit' => 100, 'offset' => 0]);
```

print all categories
```php
$limit = 100;
$offset = 0;
do {
    $categories = $client->fetchProductsCategories(['eshop_id' => 'your shop id', 'limit' => $limit, 'offset' => $offset]);
    
    foreach ($categories->data as $category) {
        // update, insert to DB
        var_dump($category);
    }

    $offset += 100;
} while (count($categories->data) !== 0);
```

#### Manufacturers
```php
$client->fetchProductsManufacturers(['eshop_id' => 'your shop id', 'limit' => 100, 'offset' => 0]);
```

#### Products Parameters
```php
$client->fetchProductsParameters(['eshop_id' => 'your shop id', 'limit' => 100, 'offset' => 0]);
```

#### Products
```php
$client->fetchProducts(['eshop_id' => 'your shop id', 'limit' => 100, 'offset' => 0]);
```

#### Payments
```php
$client->fetchAllPayments(['eshop_id' => 'your shop id']);
```

#### Deliveries
```php
$client->fetchAllDeliveries(['eshop_id' => 'your shop id']);
```

#### Delivery places
```php
$client->fetchAllDeliveryPlaces(['delivery_id' => 'delivery id', 'limit' => 100, 'offset' => 0]);
```

#### Deliveries
```php
$client->fetchAllDeliveries(['eshop_id' => 'your shop id']);
```

#### New order
```php
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
    'basket' => [ // pole produktů v košíku
        'id' => 1,  // ID aktivního produktu dodavatele. Nepovinné, pokud je uveden kód produktu
        'code' => 'DS12345678', // Kód aktivního produktu dodavatele. Nepovinné, pokud je uvedeno ID produktu
        'price_retail_vat' => 123.00, // Cena produktu s DPH
        'quantity' => 3, // Počet kusů produktu
    ],
    'test' => 1 // Testovací objednávka. V případě označení objednávky jako testovací ("test": "1"), nebude objednávka předána dodavateli.
]);
```

#### Orders status
```php
$client->fetchAllOrdersStatuses();
```

#### Fetch detail orders or by sorting
```php
$client->fetchOrders(['eshop_id' => 'your shop id', 'limit' => 100, 'offset' => 0]); // you can add id order, sort, created_from, created_to
```

I hope this package help you.

