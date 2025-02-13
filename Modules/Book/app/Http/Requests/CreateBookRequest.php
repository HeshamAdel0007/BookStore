<?php

namespace Modules\Book\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255|unique:books,name',
            'price'          => 'required|numeric|min:1',
            'stock_quantity' => 'required|numeric|min:1',
            'isbn'           => 'required|string|unique:books,isbn',
            'published_date' => 'required|date',
            'category_id'    => 'required|integer|exists:categories,id',
            'description'    => 'nullable|string',
            'book_cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
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
