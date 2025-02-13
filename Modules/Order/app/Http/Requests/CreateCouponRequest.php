<?php

namespace Modules\Order\Http\Requests;

use Modules\Order\Enums\DiscountTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'discount_value' => 'required|numeric|min:0.01',
            'discount_type' => 'nullable|in:' . implode(',', DiscountTypeEnum::getValues()),
            'usage_limit' => 'required|integer|min:1',
            'used_count' => 'required|integer|min:0',
            'start_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:start_at',
            'is_active' => 'required|boolean',
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
