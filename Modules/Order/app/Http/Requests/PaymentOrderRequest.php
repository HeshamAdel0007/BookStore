<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer,cash_on_delivery,wallet',
            'currency' => 'required|in:USD,EUR,SAR,GBP,INR,EGP',
            'taxes_rate' => 'nullable|numeric|min:0',
            'taxes_total' => 'nullable|numeric|min:0',
            'order_amount' => 'required|numeric|min:0',
            'coupon_code' => 'nullable',
            'total_price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
