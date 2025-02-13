<?php

namespace Modules\Publisher\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPublisherRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|min:3|max:255',
            'email'    => 'required|string|lowercase|email|max:255',
            'phone'    => 'required|min:7|max:16',
            'about'    => 'required|string',
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
