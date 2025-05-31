<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NamespaceRequest extends FormRequest
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
            // MAIN INFO
            'name' => [
                'required',
                'max:63',
                'regex:/^[a-z0-9]([-a-z0-9]*[a-z0-9])?$/',
                // Prevent creation of system namespaces
                function ($attribute, $value, $fail) {
                    if (preg_match('/^kube-/', $value)) {
                        $fail('Cannot create namespaces with the "kube-" prefix as they are reserved for system use.');
                    }
                },
            ],
            
            // NOTES
            'key_labels.*' => [
                'nullable',
                'regex:/^(([A-Za-z0-9][-A-Za-z0-9_.]*)?[A-Za-z0-9])?$/',
                'max:253',
            ],
            'value_labels.*' => [
                'nullable',
                'max:63',
            ],
            'key_annotations.*' => [
                'nullable',
                'regex:/^([A-Za-z0-9][-A-Za-z0-9_.]*)?[A-Za-z0-9]$/',
                'max:253',
            ],
            'value_annotations.*' => [
                'nullable',
            ],
            
            // NAMESPACE EXTRAS
            'finalizers.*' => [
                'nullable',
                'regex:/^([A-Za-z0-9][-A-Za-z0-9_.]*)?[A-Za-z0-9]$/',
                'max:253',
            ],
        ];
    }

    /**
     * Get custom validation messages
     * 
     * @return array
     */
    public function messages(): array
    {
        return [
            // MAIN INFO
            'name.required' => 'The namespace name is required.',
            'name.max' => 'The namespace name cannot exceed 63 characters.',
            'name.regex' => 'The namespace name must start with a lowercase letter or number, can contain dashes, and must end with a letter or number.',

            // NOTES
            'key_labels.*.regex' => 'Label keys must be valid DNS subdomain names.',
            'key_labels.*.max' => 'Label keys cannot exceed 253 characters.',
            'value_labels.*.max' => 'Label values cannot exceed 63 characters.',

            'key_annotations.*.regex' => 'Annotation keys must be valid DNS subdomain names.',
            'key_annotations.*.max' => 'Annotation keys cannot exceed 253 characters.',

            // NAMESPACE EXTRAS
            'finalizers.*.regex' => 'Finalizers must be valid DNS subdomain names.',
            'finalizers.*.max' => 'Finalizers cannot exceed 253 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Filter out empty values from arrays
        $this->filterEmptyArrayValues('key_labels', 'value_labels');
        $this->filterEmptyArrayValues('key_annotations', 'value_annotations');
        
        // Make sure finalizers is an array
        if ($this->has('finalizers') && !is_array($this->input('finalizers'))) {
            $this->merge(['finalizers' => []]);
        }
    }
    
    /**
     * Filter out empty values from paired key-value arrays
     * 
     * @param string $keyField
     * @param string $valueField
     * @return void
     */
    private function filterEmptyArrayValues(string $keyField, string $valueField): void
    {
        if ($this->has($keyField) && $this->has($valueField)) {
            $keys = array_filter($this->input($keyField) ?? [], function ($value) {
                return $value !== null && $value !== '';
            });
            
            $values = array_filter($this->input($valueField) ?? [], function ($value, $key) use ($keys) {
                return isset($keys[$key]) && $keys[$key] !== null && $keys[$key] !== '';
            }, ARRAY_FILTER_USE_BOTH);
            
            $this->merge([
                $keyField => $keys,
                $valueField => $values,
            ]);
        }
    }
}
