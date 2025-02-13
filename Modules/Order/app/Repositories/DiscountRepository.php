<?php

namespace Modules\Order\Repositories;

use App\Helper\Helpers;
use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Discount;
use Illuminate\Support\Facades\Log;
use Modules\Order\Enums\DiscountTypeEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Modules\Order\Interfaces\DiscountRepositoryInterface;

class DiscountRepository implements DiscountRepositoryInterface
{
    /**
     * Creates a new discount for a specific book.
     * @param mixed $request
     * @param int $bookID
     * @return JsonResponse
     */
    public function createDiscount($request, int $bookID): JsonResponse
    {
        DB::beginTransaction();
        try {
            $discountData = $this->prepareDiscountData($request, $bookID);
            $discount = Discount::create($discountData);
            DB::commit();
            return Helpers::successResponse('Discount created successfully', null, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            DB::rollBack(); // Roll back the transaction in case of failure
            Helpers::logErrorDetails($ex, 'discount creation failed: ');
            return Helpers::serverErrorResponse('Failed to create discount. Please try again later.');
        }
    } //end of createDiscount

    /**
     * Prepares the data for creating a discount.
     * @param mixed $request
     * @param mixed $book
     * @return array{book_id: mixed, created_at: \Illuminate\Support\Carbon, discount_type: mixed, discount_value: mixed, expires_at: mixed, is_active: mixed, start_at: mixed, updated_at: \Illuminate\Support\Carbon}
     */
    private function prepareDiscountData($request, $book): array
    {
        return [
            'book_id' => $book,
            'discount_value' => $request->discount_value,
            'discount_type' => $request->discount_type ?? DiscountTypeEnum::FIXED,
            'start_at' => $request->start_at ?? now(),
            'expires_at' => $request->expires_at ?? now()->addDays(10),
            'is_active' => $request->is_active,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    } // end of prepareDiscountData
}
