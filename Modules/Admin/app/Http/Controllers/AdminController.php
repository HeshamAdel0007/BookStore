<?php

namespace Modules\Admin\Http\Controllers;

use App\Helper\Helpers;
use Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Models\Customer;
use Modules\Publisher\Models\Publisher;
use Modules\Admin\Transformers\AdminResource;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Admin\Http\Requests\AdminEditRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Modules\Admin\Http\Requests\AdminCreateRequest;
use Modules\Customer\Transformers\CustomerResource;
use Modules\Publisher\Transformers\PublisherResource;
use Modules\Admin\Interfaces\AdminRepositoryInterface;
use Modules\Admin\Http\Requests\AdminEditCustomerRequest;
use Modules\Admin\Http\Requests\AdminEditPublisherRequest;

class AdminController extends Controller implements HasMiddleware
{

    protected AdminRepositoryInterface $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    } // end of construct

    public static function middleware(): array
    {
        return [
            new Middleware('role:super-admin|admin'),
            new Middleware('permission:create-admin', only: ['createAdmin']),
            new Middleware('permission:show-admin', only: ['getAdmins', 'showUser']),
            new Middleware('permission:show-publisher', only: ['getPublishers', 'showUser']),
            new Middleware('permission:show-customer', only: ['getCustomers', 'showUser']),
            new Middleware('permission:update-admin', only: ['editAdmins']),
            new Middleware('permission:update-publisher', only: ['editPublishers']),
            new Middleware('permission:update-customer', only: ['editCustomers']),
            new Middleware('permission:delete-admin', only: ['deleteAdmin']),
        ];
    } // end of middleware

    /**
     * retrieving a list of admins and returning a JSON response.
     * @return JsonResponse
     */
    public function getAdmins(): JsonResponse
    {
        return $this->getEntities([$this->adminRepository, 'getAllAdmin'], 'admins');
    } // end of getAdmins

    /**
     * retrieving a list of publishers and returning a JSON response.
     * @return JsonResponse
     */
    public function getPublishers(): JsonResponse
    {
        return $this->getEntities([$this->adminRepository, 'getAllPublisher'], 'publishers');
    } // end of getPublisher

    /**
     * retrieving a list of customers and returning a JSON response.
     * @return JsonResponse
     */
    public function getCustomers(): JsonResponse
    {
        return $this->getEntities([$this->adminRepository, 'getAllCustomer'], 'customers');
    } // end of getCustomer

    /**
     * create new admin
     * @param \Modules\Admin\Http\Requests\AdminCreateRequest $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAdmin(AdminCreateRequest $request): JsonResponse
    {
        return $this->adminRepository->create($request);
    } // end of createAdmin

    /**
     * edit admin
     * @param \Modules\Admin\Http\Requests\AdminEditRequest $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editAdmins(AdminEditRequest $request, int $id): JsonResponse
    {
        return $this->adminRepository->editUser(Admin::class, AdminResource::class, $id, $request,);
    } // end of editAdmin

    /**
     * edit publishers
     * @param \Modules\Admin\Http\Requests\AdminEditPublisherRequest $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editPublishers(AdminEditPublisherRequest $request, int $id): JsonResponse
    {
        return $this->adminRepository->editUser(Publisher::class, PublisherResource::class, $id, $request,);
    } // editPublishers

    /**
     * edit customers
     * @param \Modules\Admin\Http\Requests\AdminEditCustomerRequest $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editCustomers(AdminEditCustomerRequest $request, int $id): JsonResponse
    {
        return $this->adminRepository->editUser(Customer::class, CustomerResource::class, $id, $request,);
    } // editCustomers

    /**
     *  delete admin
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAdmin(int $id): JsonResponse
    {
        return $this->adminRepository->destroy($id);
    } // end of deleteAdmin

    /**
     * admin profile
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function adminProfile(): JsonResponse
    {
        $id = Auth::user()->id;
        return $this->adminRepository->adminProfile($id);
    } // end of adminProfile

    /**
     * show User [admin, publisher, customer]
     * @param string $type
     * @param int $id
     * @return JsonResponse
     */
    public function showUser(string $type, int $id): JsonResponse
    {
        try {
            // associative array maps each user
            $classMap = $this->getClassMap();

            $resourceMap = $this->getResourceMap();

            // this checks if the provided type exists in the classMap
            if (!isset($classMap[$type])) {
                return Helpers::notFoundResponse('Invalid user type.');
            }
            // return the user info based on type and id
            $user = $this->adminRepository->showUser(
                $resourceMap[$type],
                $classMap[$type],
                $id
            );
            if (!$user) {
                return Helpers::notFoundResponse($type . ' not found with the given ID.');
            }
            // return JSON response with user info
            return Helpers::successResponse($type . ' found', $user);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } // end of showUser

    /**
     * handles entity retrieval
     */
    private function getEntities(callable $retrievalFunction, string $entityName): JsonResponse
    {
        try {
            // Execute the provided retrieval function to get the entities
            $entities = $retrievalFunction();

            // Check if the retrieved entities collection is empty
            if ($entities->isEmpty()) {
                return Helpers::notFoundResponse('No ' . $entityName . 'found.', Response::HTTP_NOT_FOUND, $entities);
            }

            // Return a successful response with the retrieved entities
            return Helpers::successResponse($entityName . ' retrieved successfully.', $entities);
        } catch (\Exception $ex) {

            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('An error occurred while fetching' . $entityName . ', Please try again later.');
        }
    } // end of getEntities

    /**
     * ClassMap method returns an associative array that maps string keys to class names
     * @return array{admin: string, customer: string, publisher: string}
     */
    private function getClassMap(): array
    {
        return [
            'admin' => Admin::class,
            'publisher' => Publisher::class,
            'customer' => Customer::class
        ];
    } //end of getClassMap

    /**
     * ResourceMap method returns an associative array that maps string keys to class names
     * @return array{admin: string, customer: string, publisher: string}
     */
    private function getResourceMap(): array
    {
        return [
            'admin' => AdminResource::class,
            'publisher' => PublisherResource::class,
            'customer' => CustomerResource::class
        ];
    } //end of getClassMap
}// end of controller
