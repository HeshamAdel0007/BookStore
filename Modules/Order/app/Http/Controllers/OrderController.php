<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Order\Http\Requests\CreateOrderRequest;
use Modules\Order\Http\Requests\PaymentOrderRequest;
use Modules\Order\Interfaces\OrderRepositoryInterface;
use Modules\Order\Interfaces\PaymentRepositoryInterface;
use Modules\Order\Interfaces\ShippingRepositoryInterface;

class OrderController extends Controller
{
    protected OrderRepositoryInterface $orderRepository;
    protected PaymentRepositoryInterface $paymentRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, PaymentRepositoryInterface $paymentRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->paymentRepository = $paymentRepository;
    } // end of __construct

    public function order(int $id)
    {
        return $this->orderRepository->order($id);
    }
    public function createOrder(CreateOrderRequest $request)
    {
        return $this->orderRepository->createOrder($request);
    } //end of createOrder

    public function paymentInfo(int $id)
    {
        return $this->paymentRepository->showOrderPayment($id);
    }
    public function payment(PaymentOrderRequest $request, int $orderID)
    {
        return $this->paymentRepository->orderPayment($request, $orderID);
    } //end of payment
}// end of controller
