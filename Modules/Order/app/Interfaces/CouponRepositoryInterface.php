<?php

namespace Modules\Order\Interfaces;

interface CouponRepositoryInterface
{
    public function checkCoupon(int|string $code);
    public function createCoupon($request);
}
