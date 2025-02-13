<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class PublisherRegisteredRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|min:3|max:255',
            'email'    => 'required|string|lowercase|email|max:255|unique:publishers,email',
            'password' => 'required|confirmed|min:8',
            Rules\Password::defaults(),
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
