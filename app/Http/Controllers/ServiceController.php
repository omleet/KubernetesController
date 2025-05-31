<?php

namespace App\Http\Controllers;

use App\Exceptions\ClusterConnectionException;
use App\Exceptions\ClusterException;
use App\Http\Requests\ServiceRequest;
use App\Models\Cluster;
use Illuminate\Http\RedirectResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    private string $endpoint;
    private string $token;
    private float $timeout;
    private Client $client;

    /**
     * Initialize controller with cluster connection
     * 
     * @throws ClusterException
     * @throws ClusterConnectionException
     */
    public function __construct()
    {
        if (!session('clusterId')) {
            throw new ClusterException('No cluster selected');
        }

        $cluster = Cluster::findOrFail(session('clusterId'));

        if ($this->checkConnection($cluster) !== 200) {
            throw new ClusterConnectionException('Could not connect to cluster');
        }

        $this->endpoint = $cluster['endpoint'];
        $this->token = "Bearer " . $cluster['token'];
        $this->timeout = $cluster['timeout'];
        
        // Initialize the HTTP client once
        $this->client = new Client([
            'base_uri' => $this->endpoint,
            'headers' => [
                'Authorization' => $this->token,
                'Accept' => 'application/json',
            ],
            'verify' => false,
            'timeout' => $this->timeout
        ]);
    }

    /**
     * Check if the cluster is accessible
     * 
     * @param Cluster $cluster
     * @return int Status code or -1 if connection failed
     */
    private function checkConnection(Cluster $cluster): int
    {
        try {
            $clientConfig = [
                'base_uri' => $cluster['endpoint'],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'verify' => false,
                'timeout' => 0.5
            ];
            
            // Add authorization header if needed
            if ($cluster['auth_type'] !== 'P') {
                $clientConfig['headers']['Authorization'] = "Bearer " . $cluster['token'];
            }
            
            $client = new Client($clientConfig);
            $response = $client->get("/api/v1");
            
            return $response->getStatusCode();
        } catch (\Exception $e) {
            Log::warning("Cluster connection failed: " . $e->getMessage());
            return -1;
        }
    }
    
    /**
     * Display a listing of services
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $response = $this->client->get("/api/v1/services");
            $responseData = json_decode($response->getBody(), true);
            
            $services = $this->processServiceData($responseData['items'] ?? []);
            
            // Apply filters
            $showDefault = $request->query('showDefault') === "true";
            $namespaceFilter = $request->query('showNamespaceData');
            
            // Extract namespace list for filter dropdown
            $namespaceList = $this->extractNamespaceList($services, $showDefault);
            
            // Apply namespace filter if selected
            if ($namespaceFilter && $namespaceFilter !== "All") {
                $services = array_filter($services, function($service) use ($namespaceFilter) {
                    return $service['namespace'] === $namespaceFilter;
                });
            }
            
            // Filter out system namespaces if not showing default
            if (!$showDefault) {
                $services = array_filter($services, function($service) {
                    return !preg_match('/^kube-/', $service['namespace']);
                });
            }
            
            // Re-index array after filtering
            $services = array_values($services);
            
            return view('services.index', [
                'services' => $services, 
                'namespaceList' => $namespaceList
            ]);
        } catch (GuzzleException | \Exception $e) {
            Log::error("Error fetching services: " . $e->getMessage());
            return view('services.index', ['conn_error' => $e->getMessage()]);
        }
    }

    /**
     * Process service data from Kubernetes API
     * 
     * @param array $serviceItems
     * @return array
     */
    private function processServiceData(array $serviceItems): array
    {
        $services = [];
        
        foreach ($serviceItems as $item) {
            $metadata = $item['metadata'] ?? [];
            $spec = $item['spec'] ?? [];
            
            $service = [
                'name' => $metadata['name'] ?? '',
                'namespace' => $metadata['namespace'] ?? '',
                'ports' => isset($spec['ports']) ? count($spec['ports']) : 0,
                'selector' => $spec['selector'] ?? '-',
                'type' => $spec['type'] ?? 'ClusterIP'
            ];
            
            $services[] = $service;
        }
        
        return $services;
    }
    
    /**
     * Extract unique namespace list for filter dropdown
     * 
     * @param array $services
     * @param bool $showDefault Whether to include system namespaces
     * @return array
     */
    private function extractNamespaceList(array $services, bool $showDefault): array
    {
        $namespaceList = [];
        
        foreach ($services as $service) {
            $namespace = $service['namespace'];
            
            // Skip system namespaces if not showing default
            if (!$showDefault && preg_match('/^kube-/', $namespace)) {
                continue;
            }
            
            $namespaceList[] = $namespace;
        }
        
        return array_unique($namespaceList);
    }

    /**
     * Display the specified service
     *
     * @param string $namespace Namespace name
     * @param string $id Service name
     * @return View
     */
    public function show(string $namespace, string $id): View
    {
        try {
            $response = $this->client->get("/api/v1/namespaces/$namespace/services/$id");
            $jsonData = json_decode($response->getBody(), true);
            
            // Remove managed fields to clean up the JSON output
            unset($jsonData['metadata']['managedFields']);
            $json = json_encode($jsonData, JSON_PRETTY_PRINT);
            
            $data = $this->extractServiceDetails($jsonData);
            
            return view('services.show', ['service' => $data, 'json' => $json]);
        } catch (GuzzleException | \Exception $e) {
            Log::error("Error fetching service details: " . $e->getMessage());
            return view('services.show', ['conn_error' => $e->getMessage()]);
        }
    }
    
    /**
     * Extract service details from API response
     * 
     * @param array $jsonData
     * @return array
     */
    private function extractServiceDetails(array $jsonData): array
    {
        $metadata = $jsonData['metadata'] ?? [];
        $spec = $jsonData['spec'] ?? [];
        
        return [
            // Metadata
            'name' => $metadata['name'] ?? '',
            'namespace' => $metadata['namespace'] ?? '',
            'uid' => $metadata['uid'] ?? '',
            'creationTimestamp' => $metadata['creationTimestamp'] ?? '',
            'labels' => $metadata['labels'] ?? [],
            'annotations' => $metadata['annotations'] ?? [],
            
            // Spec
            'ports' => $spec['ports'] ?? [],
            'selector' => $spec['selector'] ?? [],
            'type' => $spec['type'] ?? 'ClusterIP',
            'sessionAffinity' => $spec['sessionAffinity'] ?? 'None',
            'externalTrafficPolicy' => $spec['externalTrafficPolicy'] ?? '',
            'clusterIP' => $spec['clusterIP'] ?? '',
            'externalName' => $spec['externalName'] ?? '',
        ];
    }
    
    /**
     * Show the form for creating a new service
     * 
     * @return View
     */
    public function create(): View
    {
        return view("services.create");
    }

    /**
     * Store a newly created service
     * 
     * @param ServiceRequest $request
     * @return RedirectResponse
     */
    public function store(ServiceRequest $request): RedirectResponse
    {
        try {
            $formData = $request->validated();
            $serviceData = $this->buildServiceData($formData);
            $jsonData = json_encode($serviceData);

            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'body' => $jsonData,
                'verify' => false,
                'timeout' => $this->timeout
            ]);

            $client->post("/api/v1/namespaces/{$formData['namespace']}/services");

            return redirect()->route('Services.index')
                ->with('success-msg', "Service '{$formData['name']}' was added successfully in namespace '{$formData['namespace']}'");
        } catch (GuzzleException $e) {
            Log::error("Error creating service: " . $e->getMessage());
            $errorMsg = $this->parseErrorResponse($e);
            return redirect()->back()->withInput()->with('error_msg', $errorMsg);
        } catch (\Exception $e) {
            Log::error("Unexpected error creating service: " . $e->getMessage());
            $errorMsg = $this->parseErrorMessage($e->getMessage());
            return redirect()->back()->withInput()->with('error_msg', $errorMsg);
        }
    }

    /**
     * Build service data structure from form data
     * 
     * @param array $formData
     * @return array
     */
    private function buildServiceData(array $formData): array
    {
        $data = [
            'apiVersion' => "v1",
            'kind' => "Service",
            'metadata' => [
                'name' => $formData['name'],
                'namespace' => $formData['namespace']
            ],
            'spec' => [
                'ports' => []
            ]
        ];

        // Add labels if provided
        if (!empty($formData['key_labels']) && !empty($formData['value_labels'])) {
            foreach ($formData['key_labels'] as $key => $label) {
                $data['metadata']['labels'][$label] = $formData['value_labels'][$key];
            }
        }

        // Add annotations if provided
        if (!empty($formData['key_annotations']) && !empty($formData['value_annotations'])) {
            foreach ($formData['key_annotations'] as $key => $annotation) {
                $data['metadata']['annotations'][$annotation] = $formData['value_annotations'][$key];
            }
        }
        
        // Add selector labels if provided
        if (!empty($formData['key_selectorLabels']) && !empty($formData['value_selectorLabels'])) {
            foreach ($formData['key_selectorLabels'] as $key => $selector) {
                $data['spec']['selector'][$selector] = $formData['value_selectorLabels'][$key];
            }
        }
        
        // Process ports
        if (!empty($formData['portName']) && !empty($formData['protocol']) && 
            !empty($formData['port']) && !empty($formData['target'])) {
            
            foreach ($formData['portName'] as $key => $portName) {
                $port = [
                    'name' => $portName,
                    'protocol' => $formData['protocol'][$key],
                    'port' => intval($formData['port'][$key]),
                    'targetPort' => intval($formData['target'][$key])
                ];
                
                // Add nodePort if provided and service type requires it
                if (!empty($formData['nodePort'][$key]) && 
                    isset($formData['type']) && 
                    in_array($formData['type'], ['NodePort', 'LoadBalancer'])) {
                    $port['nodePort'] = intval($formData['nodePort'][$key]);
                }
                
                $data['spec']['ports'][] = $port;
            }
        }
        
        // Add service type if specified
        if (!empty($formData['type']) && $formData['type'] !== 'Auto') {
            $data['spec']['type'] = $formData['type'];
        }
        
        // Add external name for ExternalName type services
        if (!empty($formData['type']) && $formData['type'] === 'ExternalName' && !empty($formData['externalName'])) {
            $data['spec']['externalName'] = $formData['externalName'];
        }
        
        // Add external traffic policy if specified
        if (!empty($formData['externalTrafficPolicy']) && $formData['externalTrafficPolicy'] !== 'Auto') {
            $data['spec']['externalTrafficPolicy'] = $formData['externalTrafficPolicy'];
        }
        
        // Add session affinity if specified
        if (!empty($formData['sessionAffinity']) && $formData['sessionAffinity'] !== 'Auto') {
            $data['spec']['sessionAffinity'] = $formData['sessionAffinity'];
            
            // Add session affinity timeout if ClientIP affinity is selected
            if ($formData['sessionAffinity'] === 'ClientIP' && 
                !empty($formData['sessionAffinityTimeoutSeconds'])) {
                $data['spec']['sessionAffinityConfig'] = [
                    'clientIP' => [
                        'timeoutSeconds' => intval($formData['sessionAffinityTimeoutSeconds'])
                    ]
                ];
            }
        }
        
        return $data;
    }

    /**
     * Remove a service
     * 
     * @param string $namespace Namespace name
     * @param string $id Service name
     * @return RedirectResponse
     */
    public function destroy(string $namespace, string $id): RedirectResponse
    {
        try {
            $this->client->delete("/api/v1/namespaces/$namespace/services/$id");

            return redirect()->route('Services.index')
                ->with('success-msg', "Service '$id' was deleted successfully");
        } catch (GuzzleException $e) {
            Log::error("Error deleting service: " . $e->getMessage());
            $errorMsg = $this->parseErrorResponse($e);
            return redirect()->back()->with('error_msg', $errorMsg);
        } catch (\Exception $e) {
            Log::error("Unexpected error deleting service: " . $e->getMessage());
            $errorMsg = $this->parseErrorMessage($e->getMessage());
            return redirect()->back()->with('error_msg', $errorMsg);
        }
    }

    /**
     * Parse error response from GuzzleException
     * 
     * @param GuzzleException $e
     * @return array
     */
    private function parseErrorResponse(GuzzleException $e): array
    {
        $error = [
            'message' => $e->getMessage(),
            'status' => 'Error',
            'code' => $e->getCode()
        ];
        
        // Try to extract more detailed error information if available
        if (method_exists($e, 'getResponse') && $e->getResponse()) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $parsedError = $this->parseErrorMessage($responseBody);
            
            if (!empty($parsedError)) {
                return $parsedError;
            }
        }
        
        return $error;
    }

    /**
     * Parse error message from string
     * 
     * @param string $errorMessage
     * @return array
     */
    private function parseErrorMessage(string $errorMessage): array
    {
        $error = [
            'message' => $errorMessage,
            'status' => 'Internal Server Error',
            'code' => '500'
        ];

        $jsonData = json_decode($errorMessage, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            if (isset($jsonData['message'])) {
                $error['message'] = $jsonData['message'];
            }
            if (isset($jsonData['status'])) {
                $error['status'] = $jsonData['status'];
            }
            if (isset($jsonData['code'])) {
                $error['code'] = $jsonData['code'];
            }
        }
        
        return $error;
    }
}
