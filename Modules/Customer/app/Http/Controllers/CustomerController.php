<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Customer\Interfaces\CustomerRepositoryInterface;

class CustomerController extends Controller
{

    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    } // end of __construct
    public function orders()
    {
        return $this->customerRepository->customerOrders();
    }
}
