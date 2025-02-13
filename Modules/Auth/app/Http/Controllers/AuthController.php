<?php

namespace Modules\Auth\Http\Controllers;

use App\Helper\Helpers;
use Modules\Admin\Models\Admin;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Models\Customer;
use Modules\Publisher\Models\Publisher;
use Modules\Admin\Transformers\AdminResource;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Customer\Transformers\CustomerResource;
use Modules\Publisher\Transformers\PublisherResource;

class AuthController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin', only: ['admin']),
            new Middleware('role:publisher', only: ['publisher']),
            new Middleware('role:customer', only: ['customer']),
        ];
    } // end of middleware

    /**
     * Return user info to front-end when user login
     **/
    public function admin(): JsonResponse
    {
        return $this->getUserInfo(Admin::class, AdminResource::class);
    }
    public function publisher(): JsonResponse
    {
        return $this->getUserInfo(Publisher::class, PublisherResource::class);
    }
    public function customer(): JsonResponse
    {
        return $this->getUserInfo(Customer::class, CustomerResource::class);
    }

    private function getUserInfo($modelClass, $resourceClass): JsonResponse
    {
        try {
            // get user id from Authorization
            $userAuthID = Auth::user()->id;
            $user = $modelClass::find($userAuthID);
            if (!$user) {
                return Helpers::notFoundResponse('user not found with the given ID.');
            }
            $resource = new $resourceClass($user);
            return Helpers::successResponse('retrieved successfully.', $resource);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    }
}// End of Controller
