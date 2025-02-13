<?php

namespace Modules\Order\Interfaces;

interface PaymentRepositoryInterface
{
    public function showOrderPayment(int $orderID);
    public function orderPayment($request, int $orderID);
}
