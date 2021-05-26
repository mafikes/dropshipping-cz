<?php

namespace Mafikes\DropshippingCz\Resources\Interfaces;

interface OrdersInterface
{
    public function fetch($orderId);
    public function fetchAll($additionalParameters, $limit, $offset);
    public function create($orderData, $debug);
    public function edit($orderId, $data);
    public function editStatus($orderId, $statusId);
    public function delete($orderId);
    public function fetchAllStatuses();
}
