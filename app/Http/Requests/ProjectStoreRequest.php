<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:150',
            'description'      => 'required|string|max:500',
            'year'             => 'nullable|digits:4|integer|min:1900',
            'image'            => 'nullable|mimes:png,jpg,jpeg,gif',
            'category'         => 'nullable|string|max:100',
        ];
    }
}
