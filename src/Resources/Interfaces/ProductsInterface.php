<?php

namespace Mafikes\DropshippingCz\Resources\Interfaces;

interface ProductsInterface
{
    public function fetch($productId);
    public function fetchAll($limit, $offset);
    public function fetchInventory($productIds);
    public function fetchCategories($limit, $offset);
    public function fetchManufacturers($limit, $offset);
    public function fetchParameters($limit, $offset);
    public function fetchXmlCollection();
}
