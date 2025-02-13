<?php

namespace Modules\Order\Interfaces;

interface DiscountRepositoryInterface
{
    public function createDiscount($request, int $bookID);
}
