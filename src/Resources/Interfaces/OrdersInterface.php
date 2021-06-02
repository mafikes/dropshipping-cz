<?php

namespace Mafikes\DropshippingCz\Resources\Interfaces;

interface OrdersInterface
{
    public function fetch($orderId);
    public function fetchAll($parameters);
    public function create($orderData, $test);
    public function edit($orderId, $data);
    public function editStatus($orderId, $statusId);
    public function cancel($orderId);
    public function fetchAllStatuses();
}
