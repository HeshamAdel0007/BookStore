<?php

namespace Modules\Auth\Http\Controllers;

use App\Helper\Helpers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Customer\Models\Customer;
use Modules\Publisher\Models\Publisher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Modules\Auth\Http\Requests\CustomerRegisteredRequest;
use Modules\Auth\Http\Requests\PublisherRegisteredRequest;

class RegisteredUserController extends Controller
{
    /**
     * create New Publisher
     */
    public function storePublisher(PublisherRegisteredRequest $request): JsonResponse
    {
        DB::beginTransaction(); // Start the transaction
        try {
            // Create new publisher
            $publisher = Publisher::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $publisher->assignRole('publisher'); // Add Role
            DB::commit(); // Commit the transaction
            return Helpers::successResponse('Created Publisher Is Successfully');
        } catch (\Exception $ex) {
            DB::rollBack(); // Rollback if validation fails
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } // end of storePublisher

    /**
     * create New Customer
     */
    public function storeCustomer(CustomerRegisteredRequest $request): JsonResponse
    {
        DB::beginTransaction(); // Start the transaction

        try {
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $customer->assignRole('customer'); // Add Role
            DB::commit(); // Commit the transaction
            return Helpers::successResponse('Created Customer Is Successfully');
        } catch (\Exception $ex) {
            DB::rollBack(); // Rollback if validation fails
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('An unexpected error occurred. Please try again later.', $ex->getMessage());
        }
    } // end of storeCustomer



}//End Of controller
