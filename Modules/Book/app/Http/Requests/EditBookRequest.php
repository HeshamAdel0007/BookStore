<?php

namespace Modules\Book\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:1',
            'stock_quantity' => 'required|numeric|min:1',
            'isbn'           => 'required|string|max:18',
            'published_date' => 'required|date',
            'category_id'    => 'required|integer|exists:categories,id',
            'description'    => 'nullable|string',
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
