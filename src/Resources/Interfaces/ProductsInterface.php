<?php

namespace Mafikes\DropshippingCz\Resources\Interfaces;

interface ProductsInterface
{
    public function fetch($productId);
    public function fetchAll($parameters);
    public function fetchInventory($productIds);
    public function fetchCategories($parameters);
    public function fetchManufacturers($parameters);
    public function fetchParameters($parameters);
    public function fetchXmlCollection();
}
