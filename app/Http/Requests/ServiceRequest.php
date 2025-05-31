<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
                        $fail('Cannot create services with the "kube-" prefix as they are reserved for system use.');
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

            // SELECTOR
            'key_selectorLabels.*' => [
                'nullable',
                'regex:/^(([A-Za-z0-9][-A-Za-z0-9_.]*)?[A-Za-z0-9])?$/',
                'max:253',
            ],
            'value_selectorLabels.*' => [
                'nullable',
                'max:63',
            ],

            // PORTS
            'portName' => [
                'required',
                'array',
                'min:1',
            ],
            'portName.*' => [
                'required',
                'regex:/^[a-z0-9]([-a-z0-9]*[a-z0-9])?$/',
                'max:15',
            ],
            'protocol' => [
                'required',
                'array',
                'min:1',
            ],
            'protocol.*' => [
                'required',
                'in:TCP,UDP'
            ],
            'port' => [
                'required',
                'array',
                'min:1',
            ],
            'port.*' => [
                'required',
                'integer',
                'between:1,65535'
            ],
            'target' => [
                'required',
                'array',
                'min:1',
            ],
            'target.*' => [
                'required',
                'integer',
                'between:1,65535'
            ],
            'nodePort' => [
                'nullable',
                'array',
            ],
            'nodePort.*' => [
                'nullable',
                'integer',
                'between:30000,32767'
            ],

            // EXTRAS
            'type' => [
                'required',
                'in:Auto,ClusterIP,NodePort,LoadBalancer,ExternalName'
            ],
            'externalName' => [
                'required_if:type,ExternalName',
                'nullable',
                'regex:/^(?=.{1,253}$)(?!-)[A-Za-z0-9-]{1,63}(?<!-)(\.[A-Za-z0-9-]{1,63})*$/'
            ],
            'externalTrafficPolicy' => [
                'required',
                'in:Auto,Cluster,Local'
            ],
            'sessionAffinity' => [
                'required',
                'in:Auto,None,ClientIP'
            ],
            'sessionAffinityTimeoutSeconds' => [
                'nullable',
                'integer',
                'min:0',
                'max:86400', // 24 hours in seconds
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
            'name.required' => 'The service name is required.',
            'name.max' => 'The service name cannot exceed 63 characters.',
            'name.regex' => 'The service name must start with a lowercase letter or number, can contain dashes, and must end with a letter or number.',
            'namespace.required' => 'The namespace is required.',
            'namespace.max' => 'The namespace name cannot exceed 63 characters.',
            'namespace.regex' => 'The namespace must start with a lowercase letter or number, can contain dashes, and must end with a letter or number.',

            // NOTES
            'key_labels.*.regex' => 'Label keys must be valid DNS subdomain names.',
            'key_labels.*.max' => 'Label keys cannot exceed 253 characters.',
            'value_labels.*.max' => 'Label values cannot exceed 63 characters.',
            'key_annotations.*.regex' => 'Annotation keys must be valid DNS subdomain names.',
            'key_annotations.*.max' => 'Annotation keys cannot exceed 253 characters.',

            // SELECTOR
            'key_selectorLabels.*.regex' => 'Selector label keys must be valid DNS subdomain names.',
            'key_selectorLabels.*.max' => 'Selector label keys cannot exceed 253 characters.',
            'value_selectorLabels.*.max' => 'Selector label values cannot exceed 63 characters.',

            // PORTS
            'portName.required' => 'At least one port is required.',
            'portName.min' => 'At least one port is required.',
            'portName.*.required' => 'Each port must have a name.',
            'portName.*.regex' => 'Port names must start with a lowercase letter or number, can contain dashes, and must end with a letter or number.',
            'portName.*.max' => 'Port names cannot exceed 15 characters.',
            'protocol.required' => 'Protocol is required for each port.',
            'protocol.min' => 'At least one protocol is required.',
            'protocol.*.required' => 'Protocol is required for each port.',
            'protocol.*.in' => 'Protocol must be either TCP or UDP.',
            'port.required' => 'Port number is required.',
            'port.min' => 'At least one port is required.',
            'port.*.required' => 'Port number is required for each port.',
            'port.*.integer' => 'Port number must be an integer.',
            'port.*.between' => 'Port number must be between 1 and 65535.',
            'target.required' => 'Target port is required.',
            'target.min' => 'At least one target port is required.',
            'target.*.required' => 'Target port is required for each port.',
            'target.*.integer' => 'Target port must be an integer.',
            'target.*.between' => 'Target port must be between 1 and 65535.',
            'nodePort.*.integer' => 'Node port must be an integer.',
            'nodePort.*.between' => 'Node port must be between 30000 and 32767.',

            // EXTRAS
            'type.required' => 'Service type is required.',
            'type.in' => 'Service type must be one of: Auto, ClusterIP, NodePort, LoadBalancer, or ExternalName.',
            'externalName.required_if' => 'External name is required when type is ExternalName.',
            'externalName.regex' => 'External name must be a valid DNS name.',
            'externalTrafficPolicy.required' => 'External traffic policy is required.',
            'externalTrafficPolicy.in' => 'External traffic policy must be one of: Auto, Cluster, or Local.',
            'sessionAffinity.required' => 'Session affinity is required.',
            'sessionAffinity.in' => 'Session affinity must be one of: Auto, None, or ClientIP.',
            'sessionAffinityTimeoutSeconds.integer' => 'Session affinity timeout must be an integer.',
            'sessionAffinityTimeoutSeconds.min' => 'Session affinity timeout must be at least 0 seconds.',
            'sessionAffinityTimeoutSeconds.max' => 'Session affinity timeout cannot exceed 24 hours (86400 seconds).',
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
        $this->filterEmptyArrayValues('key_selectorLabels', 'value_selectorLabels');
        
        // Process ports
        $this->filterEmptyPorts();
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
    
    /**
     * Filter out empty port entries
     * 
     * @return void
     */
    private function filterEmptyPorts(): void
    {
        $portFields = ['portName', 'protocol', 'port', 'target', 'nodePort'];
        $hasPortData = false;
        
        // Check if we have any port data
        foreach ($portFields as $field) {
            if ($this->has($field) && !empty($this->input($field))) {
                $hasPortData = true;
                break;
            }
        }
        
        if (!$hasPortData) {
            return;
        }
        
        // Get all port fields
        $portName = $this->input('portName') ?? [];
        $protocol = $this->input('protocol') ?? [];
        $port = $this->input('port') ?? [];
        $target = $this->input('target') ?? [];
        $nodePort = $this->input('nodePort') ?? [];
        
        // Find valid port entries (those with at least name, protocol, port and target)
        $validIndices = [];
        foreach ($portName as $key => $name) {
            if (!empty($name) && 
                isset($protocol[$key]) && !empty($protocol[$key]) &&
                isset($port[$key]) && !empty($port[$key]) &&
                isset($target[$key]) && !empty($target[$key])) {
                $validIndices[] = $key;
            }
        }
        
        // Filter arrays to keep only valid entries
        $filteredPortName = [];
        $filteredProtocol = [];
        $filteredPort = [];
        $filteredTarget = [];
        $filteredNodePort = [];
        
        foreach ($validIndices as $index) {
            $filteredPortName[] = $portName[$index];
            $filteredProtocol[] = $protocol[$index];
            $filteredPort[] = $port[$index];
            $filteredTarget[] = $target[$index];
            $filteredNodePort[] = $nodePort[$index] ?? null;
        }
        
        // Update request data
        $this->merge([
            'portName' => $filteredPortName,
            'protocol' => $filteredProtocol,
            'port' => $filteredPort,
            'target' => $filteredTarget,
            'nodePort' => $filteredNodePort,
        ]);
    }
}
