<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|in:USD,EUR,SAR,GBP,INR,EGP',
            'items' => 'required|array|min:1',
            'items.*.book_id' => 'required|integer|exists:books,id',
            'items.*.product_name' => 'nullable|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.product_price' => 'required|numeric|min:0',
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
