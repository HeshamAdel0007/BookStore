<?php

namespace Modules\Order\Interfaces;

interface OrderRepositoryInterface
{
    public function Order(int $id);
    public function createOrder($request);
}
