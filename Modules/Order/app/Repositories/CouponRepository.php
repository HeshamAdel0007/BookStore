<?php

namespace Modules\Order\Repositories;

use App\Helper\Helpers;
use Illuminate\Support\Str;
use Modules\Order\Interfaces\CouponRepositoryInterface;
use Modules\Order\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Order\Enums\DiscountTypeEnum;
use Symfony\Component\HttpFoundation\Response;

class CouponRepository implements CouponRepositoryInterface
{

    /**
     * Checks the validity of a coupon code.
     * @param int|string $code
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function checkCoupon(int|string $code)
    {
        try {
            $checkCouponCode = Coupon::where('code', '=', $code)->first();

            if (!$checkCouponCode) {
                return Helpers::notFoundResponse('Failed to find Coupon. Please try again later.');
            }
            return Helpers::successResponse('retrieve Coupon successfully', $checkCouponCode);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of checkCoupon

    /**
     * Creates a new coupon.
     * @param mixed $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createCoupon($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $discountData = $this->prepareCouponData($request);
            $discount = Coupon::create($discountData);
            DB::commit();
            return Helpers::successResponse('Coupon created successfully', $discount, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            DB::rollBack(); // Roll back the transaction in case of failure
            Helpers::logErrorDetails($ex, 'Coupon creation failed');
            return Helpers::serverErrorResponse('Failed to create Coupon. Please try again later.');
        }
    } //end of createCoupon

    /**
     * Prepares the data for creating a coupon.
     * @param mixed $request
     * @return array{code: string, created_at: \Illuminate\Support\Carbon, discount_type: mixed, discount_value: mixed, expires_at: mixed, is_active: mixed, start_at: mixed, updated_at: \Illuminate\Support\Carbon, usage_limit: mixed, used_count: mixed}
     */
    private function prepareCouponData($request): array
    {
        $code = $this->generateCouponCode();
        return [
            'code' => $code,
            'discount_value' => $request->discount_value,
            'discount_type' => $request->discount_type ?? DiscountTypeEnum::FIXED,
            'usage_limit' => $request->usage_limit ?? 10,
            'used_count' => $request->used_count ?? 0,
            'start_at' => $request->start_at ?? now(),
            'expires_at' => $request->expires_at ?? now()->addDays(10),
            'is_active' => $request->is_active ?? true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    } // end of prepareDiscountData

    /**
     * Generates a unique coupon code
     * @return string
     */
    private function generateCouponCode(): string
    {

        // define the length of the coupon code
        $codeLength = 6;

        // keep generating a unique code until one is found
        do {
            // generate a random coupon code
            $randomCode = Str::upper(Str::random($codeLength));
            // Check if the coupon code already exists in the database
            $exists = DB::table('coupons')->where('coupon_code', $randomCode)->exists();
        } while ($exists); // continue until a unique code is found

        return $randomCode;
    } //end of generateCouponCode
}
