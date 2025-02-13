<?php

namespace Modules\Admin\Repositories;

use App\Helper\Helpers;
use Illuminate\Support\Str;
use Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Models\Customer;
use Modules\Publisher\Models\Publisher;
use Modules\Admin\Transformers\AdminResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Modules\Customer\Transformers\CustomerResource;
use Modules\Publisher\Transformers\PublisherResource;
use Modules\Admin\Interfaces\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    protected $publisher;
    protected $customer;
    public function __construct(Publisher $publisher, Customer $customer)
    {
        $this->publisher = $publisher;
        $this->customer = $customer;
    }

    /**
     * retrieve all admins except those with the 'super-admin' role.
     */
    public function getAllAdmin()
    {
        $getAllAdmins = Admin::withoutRole('super-admin')->latest()->paginate(20);
        return AdminResource::collection($getAllAdmins)->resource;
    } // End Of getAllAdmin

    /**
     * retrieve all publisher.
     */
    public function getAllPublisher()
    {
        return $this->getAll($this->publisher, PublisherResource::class);
    } // End Of getAllPublisher

    /**
     * retrieve all customer.
     */
    public function getAllCustomer()
    {
        return $this->getAll($this->customer, CustomerResource::class);
    } // End Of getAllCustomer


    /**
     * create new admin
     * @param mixed $request
     * @return JsonResponse
     */
    public function create($request): JsonResponse
    {
        DB::beginTransaction(); // Start the transaction
        try {
            $data = $request->except([
                'password',
                'status',
                'permissions'
            ]);
            $generatePassword = Str::random(10);
            $data['password'] = bcrypt($generatePassword);

            $admin = Admin::create($data);
            $admin->assignRole('admin');
            $admin->syncPermissions([$request->permissions]);
            // Commit the transaction
            DB::commit();
            return Helpers::successResponse('Admin created successfully.', $admin, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            DB::rollBack(); // Rollback if validation fails
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    }

    /**
     * admin profile
     * @param int $id
     * @return JsonResponse|mixed|\Illuminate\Http\JsonResponse
     */
    public function adminProfile(int $id): JsonResponse
    {
        try {
            $admin = Admin::find($id);

            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => "Couldn't found the admin with this id, Please try again later.",
                ], Response::HTTP_NOT_FOUND);
            }
            $adminResource = new AdminResource($admin);
            return Helpers::successResponse('Admin retrieved successfully.', $adminResource);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } // end of adminProfile

    /**
     * Show  User [Admins, Publishers, Customers]  details
     * @param mixed $modelResource
     * @param mixed $modelName
     * @param int $id
     * @return object
     */
    public function showUser($modelResource, $modelName, int $id): object
    {
        $user = $modelName::find($id);
        return new $modelResource($user);
    } // End Of showAdmin


    /**
     * Edit user [admin, publisher, customer]
     * @param mixed $modelName
     * @param mixed $modelResource
     * @param int $id
     * @param mixed $request
     * @return JsonResponse|mixed|\Illuminate\Http\JsonResponse
     */
    public function editUser($modelName, $modelResource, int $id, $request): JsonResponse
    {
        DB::beginTransaction(); // Start the transaction

        try {
            // check id
            $user = $modelName::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => "Couldn't found the admin with this id, Please try again later.",
                ], Response::HTTP_NOT_FOUND);
            }
            $user->status = $request->status;
            $user->save();
            $user->syncPermissions($request->permissions);

            // handle single resource
            $userInfo = new $modelResource($user);

            // Commit the transaction
            DB::commit();
            return Helpers::successResponse('Admin updated successfully.', $userInfo);
        } catch (\Exception $ex) {
            DB::rollBack(); // Rollback if validation fails
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } // end of editUser

    /**
     * Delete users [admin, publisher, customer]
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            // check id
            $admin = Admin::find($id);

            if (!$admin) {
                return Helpers::notFoundResponse('Couldn\'t found the admin with this id, Please try again later.');
            }
            $admin->tokens()->delete();
            $admin->delete();
            return Helpers::successResponse('deleted admin successfully');
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } // end Of destroy

    /**
     * get all users [admin, publisher, customer]
     * @param mixed $model
     * @param mixed $resource
     */
    private function getAll($model, $resource)
    {
        $data = $model::paginate(20);
        return $resource::collection($data)->resource;
    }
} // end of AdminRepository
