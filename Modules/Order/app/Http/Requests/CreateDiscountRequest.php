<?php

namespace Modules\Order\Http\Requests;

use Modules\Order\Enums\DiscountTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateDiscountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'book_id' => 'required|integer|exists:books,id',
            'discount_value' => 'required|numeric|min:0.00',
            'discount_type' => 'nullable|in:' . implode(',', DiscountTypeEnum::getValues()),
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
