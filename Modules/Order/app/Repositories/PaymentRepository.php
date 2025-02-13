<?php

namespace Modules\Order\Repositories;

use App\Helper\Helpers;
use Illuminate\Support\Str;
use Modules\Order\Models\Order;
use Modules\Order\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Modules\Order\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Models\OrderStatus;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Enums\PaymentMethodEnum;
use Modules\Order\Enums\PaymentStatusEnum;
use Modules\Order\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{

    /**
     * Displays the payment status of a specific order.
     * @param int $orderID
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function showOrderPayment(int $orderID): JsonResponse
    {
        $payment = Payment::where('order_id', '=', $orderID)->exists();
        if (!$payment) {
            return Helpers::successResponse('this order payment pending', ['status' => 'pending']);
        }
        return Helpers::serverErrorResponse('this order payment before time');
    }

    /**
     * Processes the payment for a specific order.
     * @param mixed $request
     * @param int $orderID
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function orderPayment($request, int $orderID): JsonResponse
    {
        $payment = Payment::where('order_id', '=', $orderID)->exists();
        if (!$payment) {
            DB::beginTransaction();
            try {
                $order = $this->checkOrderID($orderID);
                // prepare the order data
                $paymentData = $this->preparePaymentData($request, $order);
                // create the order in the database
                $order = Payment::create($paymentData);
                $orderStatus = $this->changeOrderStatus($orderID, OrderStatusEnum::PROCESSING);
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack(); // Roll back the transaction in case of failure
                Helpers::logErrorDetails($ex, 'Payment creation failed: ');
                return Helpers::serverErrorResponse('Failed to Payment order. Please try again later.', $ex->getMessage());
            }
        } else {
            return Helpers::serverErrorResponse('this order payment before time');
        }
    } //end of orderPayment

    /**
     * Prepares the data for creating a payment record.
     * @param mixed $request
     * @param mixed $order
     * @return array{coupon_discount: mixed, created_at: \Illuminate\Support\Carbon, currency: mixed, customer_id: mixed, order_amount: mixed, order_id: mixed, paid_at: \Illuminate\Support\Carbon, payment_method: mixed, taxes_rate: mixed, taxes_total: mixed, total_price: float|int, transaction_id: string, updated_at: \Illuminate\Support\Carbon}
     */
    private function preparePaymentData($request, $order): array
    {
        $transactionID = $this->generateTransactionId($order->id);
        $orderPrice = $order->total_price;
        $couponDiscount = $this->calculateCouponDiscount($request->coupon_code, $orderPrice);
        $totalPrice = $orderPrice - $couponDiscount;
        return [
            'order_id' => $order->id,
            'customer_id' => Auth::user()->id,
            'transaction_id' => $transactionID,
            'payment_method' => $request->payment_method ?? PaymentMethodEnum::CREDIT_CARD,
            'taxes_rate' => $request->taxes_rate,
            'taxes_total' => $request->taxes_total,
            'currency' => $order->currency,
            'order_amount' => $orderPrice,
            'coupon_discount' => $couponDiscount,
            'total_price' => $totalPrice,
            'paid_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    } //end of preparePaymentData

    /**
     * Generates a unique transaction ID.
     * @param mixed $orderId
     * @return string
     */
    private function generateTransactionId($orderId): string
    {
        $uuid = Str::uuid()->toString();
        $timestamp = now()->timestamp;
        $hash = hash('sha256', $uuid . $orderId . $timestamp);
        return substr($hash, 0, 32);
    } // end of generateTransactionId

    /**
     * Checks if an order exists.
     * @param int $id
     * @throws \Exception
     * @return TModel
     */
    private function checkOrderID(int $id)
    {
        $order = Order::find($id);
        if (!$order) {
            throw new \Exception('Order not found.');
        }
        return $order;
    }

    /**
     * Calculates the discount for a coupon.
     * @param mixed $code
     * @param mixed $totalPrice
     */
    private function calculateCouponDiscount($code, $totalPrice)
    {
        if (!$code) {
            return 0.0; // If no coupon code is provided, return no discount
        }

        // retrieve the coupon data from the database
        $couponCode = Coupon::where('code', '=', $code)->first();

        // validate the coupon
        if (
            !$couponCode ||
            $couponCode->expires_at < now() ||
            !$couponCode->is_active ||
            $couponCode->usage_limit <= $couponCode->used_count
        ) {
            return 0.0; // If the coupon is invalid, return no discount
        }

        // increment the usage count
        $couponCode->increment('used_count');

        // calculate the discount based on the type
        return $couponCode->discount_type === 'percentage'
            ? ($couponCode->discount_value / 100) * $totalPrice // Percentage discount
            : $couponCode->discount_value; // Fixed value discount

    } // end calculateCouponDiscount

    /**
     * Updates the status of an order.
     * @param mixed $orderID
     * @param mixed $status
     * @return void
     */
    private function changeOrderStatus($orderID, $status)
    {
        $orderStatus = OrderStatus::where('order_id', '=', $orderID)->update([
            'status' =>  $status,
            'status_updated_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
