<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Customer\Models\Customer;
use Modules\Publisher\Models\Publisher;
use Modules\Admin\Interfaces\AdminSoftDeleteInterface;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

/**
 *  The controller is handling soft deletion, restoration, and permanent deletion of Publisher and Customer models.
 * It also provides methods to retrieve trashed (soft-deleted) records for these models
 */
class AdminSoftDeleteController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin|super-admin'),
            new Middleware('permission:delete-publisher', only: ['softDeletePublisher', 'publisherTrashed', 'restorePublisher', 'destroyPublisher']),
            new Middleware('permission:delete-customer', only: ['softDeleteCustomer', 'customerTrashed', 'restoreCustomer', 'destroyCustomer']),
        ];
    } // end of middleware
    protected AdminSoftDeleteInterface  $adminSoftDeleteRepository;

    public function __construct(AdminSoftDeleteInterface  $adminSoftDeleteRepository)
    {
        $this->adminSoftDeleteRepository = $adminSoftDeleteRepository;
    } //end of construct

    public function softDeletePublisher(int $id): JsonResponse
    {
        return $this->adminSoftDeleteRepository->softDeleteUsers(Publisher::class, $id);
    } // end of softDeletePublisher


    public function softDeleteCustomer(int $id): JsonResponse
    {
        return $this->adminSoftDeleteRepository->softDeleteUsers(Customer::class, $id);
    } // end of softDeleteCustomer

    public function publisherTrashed()
    {
        return $this->adminSoftDeleteRepository->getTrashedUsers(Publisher::class);
    } //end of publisherTrashed

    public function customerTrashed()
    {
        return $this->adminSoftDeleteRepository->getTrashedUsers(Customer::class);
    } //end of customerTrashed

    public function restorePublisher(int $id)
    {
        return $this->adminSoftDeleteRepository->restoredUser(Publisher::class, $id);
    } // end of restorePublisher

    public function restoreCustomer(int $id)
    {
        return $this->adminSoftDeleteRepository->restoredUser(Customer::class, $id);
    } // end of restoreCustomer

    public function destroyPublisher(int $id)
    {
        return $this->adminSoftDeleteRepository->forceDeleteUser(Publisher::class, $id);
    } // end of destroyPublisher

    public function destroyCustomer(int $id)
    {
        return $this->adminSoftDeleteRepository->forceDeleteUser(Customer::class, $id);
    } // end of destroyCustomer
}//end of controller
