<?php

namespace Modules\Order\Repositories;

use App\Helper\Helpers;
use Illuminate\Http\Response;
use Modules\Order\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Models\OrderItems;
use Modules\Order\Enums\CurrencyEnum;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Models\OrderStatus;
use Modules\Order\Transformers\OrderItemsResource;
use Modules\Order\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{


    /**
     * Retrieves the details of a specific order.
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function order(int $id): JsonResponse
    {
        try {
            $order = Order::find($id);
            if (!$order) {
                return Helpers::notFoundResponse('Not found Orders');
            }
            $orderResource = new OrderItemsResource($order);
            return Helpers::successResponse(' retrieve Order successfully', $orderResource);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('Failed to find order. Please try again later.');
        }
    }

    /**
     * Creates a new order.
     * @param mixed $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createOrder($request): JsonResponse
    {
        DB::beginTransaction(); // Start the transaction
        try {
            // get the current customer ID
            $customerId = Auth::id();

            // prepare the order data
            $orderData = $this->prepareOrderData($request, $customerId);
            // create the order in the database
            $order = Order::create($orderData);

            // prepare the order items
            $orderItems = $this->prepareOrderItems($request->items, $order);
            // Insert the items into the database
            OrderItems::insert($orderItems);

            $orderStatus =  $this->orderStatus($order->id, OrderStatusEnum::PENDING);
            // Commit the transaction if everything succeeds
            DB::commit();
            return Helpers::successResponse('Order created successfully', null, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            DB::rollBack(); // Roll back the transaction in case of failure
            Helpers::logErrorDetails($ex, 'order creation failed');
            return Helpers::serverErrorResponse('Failed to create order. Please try again later.');
        }
    } //end of createOrder


    /**
     * Prepares the data for creating an order.
     * @param mixed $request
     * @param mixed $customerId
     * @return array{currency: mixed, customer_id: mixed, quantity: mixed, total_price: mixed}
     */
    private function prepareOrderData($request, $customerId): array
    {
        return [
            'customer_id' => $customerId,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'currency' => $request->currency ?? CurrencyEnum::USD,
        ];
    }

    /**
     * Prepares the order items for insertion into the database.
     * @param array $items
     * @param mixed $order
     * @return array
     */
    private function prepareOrderItems(array $items, $order): array
    {
        return collect($items)->map(function ($item) use ($order) {
            // Calculate the total price before discount
            $totalPriceBeforeDiscount = $item['quantity'] * $item['product_price'];
            // Calculate the discount
            $discount = $this->calculateProductDiscount($item['book_id'], $totalPriceBeforeDiscount);
            // Calculate the total price after discount
            $totalPriceAfterDiscount = $totalPriceBeforeDiscount - $discount;
            // Return a structured array for this item
            return [
                'order_id' => $order->id,
                'book_id' => $item['book_id'],
                'product_name' => $item['product_name'] ?? null,
                'quantity' => $item['quantity'],
                'product_price' => $item['product_price'],
                'main_total_price' => $totalPriceBeforeDiscount,
                'discount' => $discount,
                'total_price' => $totalPriceAfterDiscount,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();
    }

    /**
     * Calculates the discount for a product.
     * @param mixed $bookId
     * @param mixed $totalPrice
     */
    private function calculateProductDiscount($bookId, $totalPrice)
    {
        $discount = null;
        // get discount for the product
        $productDiscount = Discount::where('book_id', '=', $bookId)->first();
        // check if the discount is active and not expired
        if ($productDiscount && $productDiscount->expires_at >= now() && $productDiscount->is_active == true) {
            // calculate the discount based on type
            $discount = $productDiscount->discount_type === 'percentage'
                ? ($productDiscount->discount_value / 100) * $totalPrice
                : $productDiscount->discount_value;
        }
        // return the discount value
        return $discount;
    } // end calculateProductDiscount

    /**
     * Sets the status of an order.
     * @param mixed $orderId
     * @param mixed $status
     * @return void
     */
    private function orderStatus($orderId, $status)
    {
        $orderStatusData = [
            'order_id' => $orderId,
            'status' => $status,
            'status_updated_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        OrderStatus::create($orderStatusData);
    }
}// end of OrderRepository
