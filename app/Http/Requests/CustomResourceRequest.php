<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * @return bool
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
            'resource' => [
                'required',
                'string',
                'json' // Validate that the string is valid JSON
            ]
        ];
    }

    /**
     * Get custom validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'resource.required' => 'The resource JSON is required.',
            'resource.string' => 'The resource must be a string.',
            'resource.json' => 'The resource must be a valid JSON string.'
        ];
    }
}
