<?php

namespace Modules\Admin\Repositories;

use App\Helper\Helpers;
use Illuminate\Http\JsonResponse;
use Modules\Admin\Interfaces\AdminSoftDeleteInterface;

class AdminSoftDeleteRepository implements AdminSoftDeleteInterface
{
    /**
     * user is not permanently removed but marked as deleted (trashed)
     * @param mixed $modelName
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function softDeleteUsers($modelName, int $id): JsonResponse
    {
        try {
            // check id
            $user = $modelName::find($id);

            if (!$user) {
                return Helpers::notFoundResponse('Couldn\'t found the user with this id, Please try again later.');
            }
            $user->tokens()->delete();
            $user->delete();
            return Helpers::successResponse('deleted user successfully');
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of softDeleteUsers

    /**
     * retrieves all soft-deleted users (those in the "trashed" state).
     * @param mixed $modelName
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTrashedUsers($modelName): JsonResponse
    {
        try {
            // Retrieve only trashed users
            $usersTrashed = $modelName::onlyTrashed()->paginate(25);

            if ($usersTrashed->isEmpty()) {
                return Helpers::successResponse('No trashed users found.', []);
            }

            return Helpers::successResponse('Trashed users retrieved successfully.', $usersTrashed);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } // end of getTrashedUsers

    /**
     * Restore a soft-deleted publisher.
     * @param mixed $modelName
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function restoredUser($modelName, int $id): JsonResponse
    {
        try {
            $user = $modelName::withTrashed()->find($id);

            if (!$user || !$user->trashed()) {
                return Helpers::notFoundResponse('user not found or not trashed.');
            }
            // Restore the user
            $user->restore();
            return Helpers::successResponse('user restored successfully.');
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of restoredUser

    /**
     * Permanently delete a publisher, including soft-deleted ones.
     * @param mixed $modelName
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function forceDeleteUser($modelName, int $id): JsonResponse
    {
        try {
            $user = $modelName::withTrashed()->find($id);

            if (!$user) {
                return Helpers::notFoundResponse('user not found.');
            }
            $user->tokens()->delete();
            // Permanently delete the publisher
            $user->forceDelete();
            return Helpers::successResponse('user permanently deleted successfully.');
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of forceDelete

}//end of repository
