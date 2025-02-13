<?php

namespace Modules\Customer\Repositories;

use App\Helper\Helpers;
use Modules\Customer\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * retrieve customer orders
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function customerOrders(): JsonResponse
    {
        try {
            $customerID = Auth::id();
            $customer = Customer::find($customerID);
            $orders = $customer->orders;
            if (count($orders) == 0) {
                return Helpers::successResponse('Not found Orders');
            }
            return Helpers::successResponse('retrieve Order successfully', $orders);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('Failed to find order. Please try again later.');
        }
    }
}
