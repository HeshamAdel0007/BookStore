<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Http\Requests\CreateCouponRequest;
use Modules\Order\Interfaces\CouponRepositoryInterface;

class CouponController extends Controller
{
    protected CouponRepositoryInterface $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    } // end of __construct

    public function check($code)
    {
        return $this->couponRepository->checkCoupon($code);
    } // end of create
    public function create(CreateCouponRequest $request)
    {
        return $this->couponRepository->createCoupon($request);
    } // end of create
}
