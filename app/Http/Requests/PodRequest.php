<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PodRequest extends FormRequest
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
                function ($attribute, $value, $fail) {
                    if (preg_match('/^kube-/', $value)) {
                        $fail('Cannot create pods with the "kube-" prefix as they are reserved for system use.');
                    }
                },
            ],
            'namespace' => [
                'required',
                'max:63',
                'regex:/^[a-z0-9]([-a-z0-9]*[a-z0-9])?$/'
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

            // CONTAINERS
            'containers' => [
                'required',
                'array',
                'min:1',
            ],
            'containers.*.name' => [
                'required',
                'max:63',
                'regex:/^(([A-Za-z0-9][-A-Za-z0-9_.]*)?[A-Za-z0-9])?$/'
            ],
            'containers.*.image' => [
                'required',
                'string',
                'max:255',
            ],
            'containers.*.imagePullPolicy' => [
                'required',
                'in:IfNotPresent,Always,Never'
            ],
            'containers.*.ports.*' => [
                'nullable',
                'integer',
                'between:1,65535',
            ],
            'containers.*.env.key.*' => [
                'nullable',
                'regex:/^(([A-Za-z0-9][-A-Za-z0-9_.]*)?[A-Za-z0-9])?$/',
                'max:253',
            ],  
            'containers.*.env.value.*' => [
                'nullable',
            ],

            //EXTRAS
            'restartpolicy' => [
                'required',
                'in:Always,OnFailure,Never'
            ],
            'graceperiod' => [
                'nullable',
                'integer',
                'min:0',
                'max:2147483647',
            ]
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
            'name.required' => 'The pod name is required.',
            'name.max' => 'The pod name cannot exceed 63 characters.',
            'name.regex' => 'The pod name must start with a lowercase letter or number, can contain dashes, and must end with a letter or number.',
            'namespace.required' => 'The namespace is required.',
            'namespace.max' => 'The namespace name cannot exceed 63 characters.',
            'namespace.regex' => 'The namespace must start with a lowercase letter or number, can contain dashes, and must end with a letter or number.',

            // NOTES
            'key_labels.*.regex' => 'Label keys must be valid DNS subdomain names.',
            'key_labels.*.max' => 'Label keys cannot exceed 253 characters.',
            'value_labels.*.max' => 'Label values cannot exceed 63 characters.',
            'key_annotations.*.regex' => 'Annotation keys must be valid DNS subdomain names.',
            'key_annotations.*.max' => 'Annotation keys cannot exceed 253 characters.',

            // CONTAINERS
            'containers.required' => 'At least one container is required.',
            'containers.min' => 'At least one container is required.',
            'containers.*.name.required' => 'Each container must have a name.',
            'containers.*.name.max' => 'Container names cannot exceed 63 characters.',
            'containers.*.name.regex' => 'Container names must be valid DNS subdomain names.',
            'containers.*.image.required' => 'Each container must have an image.',
            'containers.*.image.max' => 'Container image names cannot exceed 255 characters.',
            'containers.*.imagePullPolicy.required' => 'Each container must have an image pull policy.',
            'containers.*.imagePullPolicy.in' => 'Image pull policy must be one of: IfNotPresent, Always, or Never.',
            'containers.*.ports.*.integer' => 'Container ports must be integers.',
            'containers.*.ports.*.between' => 'Container ports must be between 1 and 65535.',
            'containers.*.env.key.*.regex' => 'Environment variable names must be valid DNS subdomain names.',
            'containers.*.env.key.*.max' => 'Environment variable names cannot exceed 253 characters.',

            // EXTRAS
            'restartpolicy.required' => 'A restart policy is required.',
            'restartpolicy.in' => 'Restart policy must be one of: Always, OnFailure, or Never.',
            'graceperiod.integer' => 'Grace period must be an integer.',
            'graceperiod.min' => 'Grace period must be a positive number.',
            'graceperiod.max' => 'Grace period is too large.',
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
        
        // Process containers
        if ($this->has('containers')) {
            $containers = $this->input('containers');
            
            foreach ($containers as $key => $container) {
                // Filter empty ports
                if (isset($container['ports'])) {
                    $containers[$key]['ports'] = array_filter($container['ports'], function($port) {
                        return $port !== null && $port !== '';
                    });
                }
                
                // Filter empty environment variables
                if (isset($container['env']) && isset($container['env']['key'])) {
                    $envKeys = array_filter($container['env']['key'] ?? [], function($value) {
                        return $value !== null && $value !== '';
                    });
                    
                    $envValues = array_filter($container['env']['value'] ?? [], function($value, $key) use ($envKeys) {
                        return isset($envKeys[$key]) && $envKeys[$key] !== null && $envKeys[$key] !== '';
                    }, ARRAY_FILTER_USE_BOTH);
                    
                    $containers[$key]['env']['key'] = $envKeys;
                    $containers[$key]['env']['value'] = $envValues;
                }
            }
            
            $this->merge(['containers' => $containers]);
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
