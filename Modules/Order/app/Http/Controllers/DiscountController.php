<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Http\Requests\CreateDiscountRequest;
use Modules\Order\Interfaces\DiscountRepositoryInterface;

class DiscountController extends Controller
{
    protected DiscountRepositoryInterface $discountRepository;

    public function __construct(DiscountRepositoryInterface $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    } // end of __construct
    public function create(CreateDiscountRequest $request, $bookID)
    {
        return $this->discountRepository->createDiscount($request, $bookID);
    } // end of create
}
