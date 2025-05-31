<?php

namespace App\Http\Controllers;

use App\Exceptions\ClusterConnectionException;
use App\Exceptions\ClusterException;
use App\Http\Requests\PodRequest;
use App\Models\Cluster;
use Illuminate\Http\RedirectResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PodController extends Controller
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
     * Display a listing of pods
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $response = $this->client->get("/api/v1/pods");
            $responseData = json_decode($response->getBody(), true);
            
            $pods = $this->processPodData($responseData['items'] ?? []);
            
            // Apply filters
            $showDefault = $request->query('showDefault') === "true";
            $namespaceFilter = $request->query('showNamespaceData');
            $hideDeploymentPods = $request->query('hideDeploymentPods') === "true";
            
            // Extract namespace list for filter dropdown
            $namespaceList = $this->extractNamespaceList($pods, $showDefault);
            
            // Apply namespace filter if selected
            if ($namespaceFilter && $namespaceFilter !== "All") {
                $pods = array_filter($pods, function($pod) use ($namespaceFilter) {
                    return $pod['namespace'] === $namespaceFilter;
                });
            }
            
            // Filter out system namespaces if not showing default
            if (!$showDefault) {
                $pods = array_filter($pods, function($pod) {
                    return !preg_match('/^kube-/', $pod['namespace']);
                });
            }
            
            // Filter out deployment pods if requested
            if ($hideDeploymentPods) {
                $pods = array_filter($pods, function($pod) {
                    return !$pod['isDeployment'];
                });
            }
            
            // Re-index array after filtering
            $pods = array_values($pods);
            
            return view('pods.index', [
                'pods' => $pods, 
                'namespaceList' => $namespaceList
            ]);
        } catch (GuzzleException | \Exception $e) {
            Log::error("Error fetching pods: " . $e->getMessage());
            return view('pods.index', ['conn_error' => $e->getMessage()]);
        }
    }

    /**
     * Process pod data from Kubernetes API
     * 
     * @param array $podItems
     * @return array
     */
    private function processPodData(array $podItems): array
    {
        $pods = [];
        
        foreach ($podItems as $item) {
            $metadata = $item['metadata'] ?? [];
            $status = $item['status'] ?? [];
            
            $pod = [
                'name' => $metadata['name'] ?? '',
                'namespace' => $metadata['namespace'] ?? '',
                'podIP' => $status['podIP'] ?? '-',
                'totalContainers' => isset($status['containerStatuses']) ? count($status['containerStatuses']) : '',
                'status' => $status['phase'] ?? 'Unknown',
                'isDeployment' => false
            ];
            
            // Check if pod is part of a deployment
            if (isset($metadata['ownerReferences'])) {
                foreach ($metadata['ownerReferences'] as $reference) {
                    if (($reference['kind'] ?? '') === "ReplicaSet") {
                        $pod['isDeployment'] = true;
                        break;
                    }
                }
            }
            
            $pods[] = $pod;
        }
        
        return $pods;
    }
    
    /**
     * Extract unique namespace list for filter dropdown
     * 
     * @param array $pods
     * @param bool $showDefault Whether to include system namespaces
     * @return array
     */
    private function extractNamespaceList(array $pods, bool $showDefault): array
    {
        $namespaceList = [];
        
        foreach ($pods as $pod) {
            $namespace = $pod['namespace'];
            
            // Skip system namespaces if not showing default
            if (!$showDefault && preg_match('/^kube-/', $namespace)) {
                continue;
            }
            
            $namespaceList[] = $namespace;
        }
        
        return array_unique($namespaceList);
    }

    /**
     * Display the specified pod
     *
     * @param string $namespace Namespace name
     * @param string $id Pod name
     * @return View
     */
    public function show(string $namespace, string $id): View
    {
        try {
            $response = $this->client->get("/api/v1/namespaces/$namespace/pods/$id");
            $jsonData = json_decode($response->getBody(), true);
            
            // Remove managed fields to clean up the JSON output
            unset($jsonData['metadata']['managedFields']);
            $json = json_encode($jsonData, JSON_PRETTY_PRINT);
            
            $data = $this->extractPodDetails($jsonData);
            
            return view('pods.show', ['pod' => $data, 'json' => $json]);
        } catch (GuzzleException | \Exception $e) {
            Log::error("Error fetching pod details: " . $e->getMessage());
            return view('pods.show', ['conn_error' => $e->getMessage()]);
        }
    }
    
    /**
     * Extract pod details from API response
     * 
     * @param array $jsonData
     * @return array
     */
    private function extractPodDetails(array $jsonData): array
    {
        $metadata = $jsonData['metadata'] ?? [];
        $spec = $jsonData['spec'] ?? [];
        $status = $jsonData['status'] ?? [];
        
        return [
            // Metadata
            'name' => $metadata['name'] ?? '',
            'namespace' => $metadata['namespace'] ?? '',
            'uid' => $metadata['uid'] ?? '',
            'creationTimestamp' => $metadata['creationTimestamp'] ?? '',
            'labels' => $metadata['labels'] ?? [],
            'annotations' => $metadata['annotations'] ?? [],
            
            // Spec
            'containers' => $spec['containers'] ?? [],
            'restartPolicy' => $spec['restartPolicy'] ?? '',
            'terminationGracePeriodSeconds' => $spec['terminationGracePeriodSeconds'] ?? '',
            'nodeName' => $spec['nodeName'] ?? '',
            
            // Status
            'status' => $status['phase'] ?? 'Unknown',
            'hostIp' => $status['hostIP'] ?? 'Unknown',
            'podIp' => $status['podIP'] ?? 'Unknown',
        ];
    }
    
    /**
     * Show the form for creating a new pod
     * 
     * @return View
     */
    public function create(): View
    {
        return view("pods.create");
    }

    /**
     * Store a newly created pod
     * 
     * @param PodRequest $request
     * @return RedirectResponse
     */
    public function store(PodRequest $request): RedirectResponse
    {
        try {
            $formData = $request->validated();
            $podData = $this->buildPodData($formData);
            $jsonData = json_encode($podData);

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

            $client->post("/api/v1/namespaces/{$formData['namespace']}/pods");

            return redirect()->route('Pods.index')
                ->with('success-msg', "Pod '{$formData['name']}' was added successfully in namespace '{$formData['namespace']}'");
        } catch (GuzzleException $e) {
            Log::error("Error creating pod: " . $e->getMessage());
            $errorMsg = $this->parseErrorResponse($e);
            return redirect()->back()->withInput()->with('error_msg', $errorMsg);
        } catch (\Exception $e) {
            Log::error("Unexpected error creating pod: " . $e->getMessage());
            $errorMsg = $this->parseErrorMessage($e->getMessage());
            return redirect()->back()->withInput()->with('error_msg', $errorMsg);
        }
    }

    /**
     * Build pod data structure from form data
     * 
     * @param array $formData
     * @return array
     */
    private function buildPodData(array $formData): array
    {
        $data = [
            'apiVersion' => "v1",
            'kind' => "Pod",
            'metadata' => [
                'name' => $formData['name'],
                'namespace' => $formData['namespace']
            ],
            'spec' => [
                'containers' => [],
                'restartPolicy' => $formData['restartpolicy']
            ]
        ];

        // Add labels if provided
        if (isset($formData['key_labels']) && isset($formData['value_labels'])) {
            foreach ($formData['key_labels'] as $key => $label) {
                $data['metadata']['labels'][$label] = $formData['value_labels'][$key];
            }
        }

        // Add annotations if provided
        if (isset($formData['key_annotations']) && isset($formData['value_annotations'])) {
            foreach ($formData['key_annotations'] as $key => $annotation) {
                $data['metadata']['annotations'][$annotation] = $formData['value_annotations'][$key];
            }
        }
        
        // Add grace period if provided
        if (!empty($formData['graceperiod'])) {
            $data['spec']['terminationGracePeriodSeconds'] = intval($formData['graceperiod']);
        }
        
        // Process containers
        foreach ($formData['containers'] as $container) {
            $containerData = [
                'name' => $container['name'],
                'image' => $container['image'],
                'imagePullPolicy' => $container['imagePullPolicy']
            ];
            
            // Add ports if provided
            if (!empty($container['ports'])) {
                $containerData['ports'] = array_map(function($port) {
                    return ['containerPort' => intval($port)];
                }, $container['ports']);
            }
            
            // Add environment variables if provided
            if (!empty($container['env']['key'])) {
                $containerData['env'] = [];
                foreach ($container['env']['key'] as $keyEnv => $envName) {
                    $containerData['env'][] = [
                        'name' => $envName,
                        'value' => $container['env']['value'][$keyEnv] ?? ''
                    ];
                }
            }
            
            $data['spec']['containers'][] = $containerData;
        }
        
        return $data;
    }

    /**
     * Remove a pod
     * 
     * @param string $namespace Namespace name
     * @param string $id Pod name
     * @return RedirectResponse
     */
    public function destroy(string $namespace, string $id): RedirectResponse
    {
        try {
            $this->client->delete("/api/v1/namespaces/$namespace/pods/$id");

            return redirect()->route('Pods.index')
                ->with('success-msg', "Pod '$id' was deleted successfully");
        } catch (GuzzleException $e) {
            Log::error("Error deleting pod: " . $e->getMessage());
            $errorMsg = $this->parseErrorResponse($e);
            return redirect()->back()->with('error_msg', $errorMsg);
        } catch (\Exception $e) {
            Log::error("Unexpected error deleting pod: " . $e->getMessage());
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
