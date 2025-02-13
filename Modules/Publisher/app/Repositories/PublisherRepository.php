<?php

namespace Modules\Publisher\Repositories;

use App\Helper\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Publisher\Models\Publisher;
use Modules\Publisher\Transformers\PublisherResource;
use Modules\Publisher\Interfaces\PublisherRepositoryInterface;
use Modules\Publisher\Transformers\PublisherBooksResource;

class PublisherRepository implements PublisherRepositoryInterface
{

    public function publisherDetails(int $id): JsonResponse
    {
        try {
            // fetch publisher by ID
            $publisher = Publisher::find($id);
            // transform the publisher using a resource
            $publisherResource = new PublisherResource($publisher);
            return Helpers::successResponse('Publisher retrieved successfully.', $publisherResource);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of publisherDetails

    public function publisherBooks(int $id): JsonResponse
    {
        try {
            // fetch publisher by ID
            $publisher = Publisher::find($id);
            // transform the publisher using a resource
            $publisherBooks = new PublisherBooksResource($publisher);
            return Helpers::successResponse('Publisher retrieved successfully.', $publisherBooks);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of publisherBooks


    public function orders(int $id): JsonResponse
    {
        try {
            $publisher = Publisher::find($id);
            $orders = $publisher->orders()->latest()->paginate(10);
            return Helpers::successResponse('Order retrieved successfully.', $orders);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    }

    public function orderItemInfo(int $id, int $orderID): JsonResponse
    {
        try {
            $publisher = Publisher::find($id);
            $orders = $publisher->orderItems()->where('order_id', '=', $orderID)->get();
            return Helpers::successResponse('Order Items retrieved successfully.', $orders);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    }

    /**
     * get publisher info with books is publish
     */
    public function show(int $id): JsonResponse
    {
        try {
            // fetch publisher by ID
            $publisher = $this->findPublisher($id);
            // transform the publisher using a resource
            $publisherResource = new PublisherResource($publisher);
            return Helpers::successResponse('Publisher retrieved successfully.', $publisherResource);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } // end of getPublisher

    public function edit($request, int $id): JsonResponse
    {
        DB::beginTransaction(); // Start the transaction

        try {
            // fetch publisher by ID
            $publisher = $this->findPublisher($id);

            $publisher->update($request->only(['name', 'email', 'phone', 'about']));
            // transform the publisher using a resource
            $publisherResource = new PublisherResource($publisher);

            // Commit the transaction
            DB::commit();
            return Helpers::successResponse('Publisher updated successfully.', $publisherResource);
        } catch (\Exception $ex) {
            DB::rollBack(); // Rollback if validation fails
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of edit publisher

    /**
     * Soft delete a publisher and its associated tokens.
     */
    public function softDeleted(int $id): JsonResponse
    {
        try {
            $publisher = $this->findPublisher($id);

            // Soft delete tokens and publisher
            $publisher->tokens()->delete();
            $publisher->delete();

            return Helpers::successResponse('Publisher deleted successfully.');
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of softDelete

    /**
     * find a publisher by ID or throw an exception if not found
     */
    private function findPublisher(int $id): ?Publisher
    {
        $publisher = Publisher::find($id);
        if (!$publisher) {
            throw new \Exception('Publisher not found with the given ID.');
        }
        return $publisher;
    } //end of funPublisher
} // end of repository
