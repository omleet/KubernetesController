<?php

namespace App\Http\Controllers;

use App\Exceptions\ClusterConnectionException;
use App\Exceptions\ClusterException;
use App\Http\Requests\NamespaceRequest;
use App\Models\Cluster;
use Illuminate\Http\RedirectResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NamespaceController extends Controller
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
     * Display a listing of namespaces
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $response = $this->client->get("/api/v1/namespaces");
            $responseData = json_decode($response->getBody(), true);
            
            $namespaces = $this->processNamespaceData($responseData['items'] ?? [], $request->query('showDefault') === "true");
            
            return view('namespaces.index', ['namespaces' => $namespaces]);
        } catch (GuzzleException | \Exception $e) {
            Log::error("Error fetching namespaces: " . $e->getMessage());
            return view('namespaces.index', ['conn_error' => $e->getMessage()]);
        }
    }

    /**
     * Process namespace data from Kubernetes API
     * 
     * @param array $namespaceItems
     * @param bool $showDefault Whether to include system namespaces
     * @return array
     */
    private function processNamespaceData(array $namespaceItems, bool $showDefault): array
    {
        $namespaces = [];
        
        foreach ($namespaceItems as $item) {
            // Skip system namespaces if not showing default
            if (!$showDefault && preg_match('/^kube-/', $item['metadata']['name'])) {
                continue;
            }
            
            $namespaces[] = [
                'name' => $item['metadata']['name'],
                'creation' => $item['metadata']['creationTimestamp'],
                'status' => $item['status']['phase'] ?? 'Unknown',
                'uid' => $item['metadata']['uid'] ?? '',
                'isSystem' => preg_match('/^kube-/', $item['metadata']['name'])
            ];
        }
        
        return $namespaces;
    }

    /**
     * Display the specified namespace
     *
     * @param string $id Namespace name
     * @return View
     */
    public function show(string $id): View
    {
        try {
            $response = $this->client->get("/api/v1/namespaces/" . $id);
            $jsonData = json_decode($response->getBody(), true);
            
            // Remove managed fields to clean up the JSON output
            unset($jsonData['metadata']['managedFields']);
            $json = json_encode($jsonData, JSON_PRETTY_PRINT);
            
            $data = $this->extractNamespaceDetails($jsonData);
            
            return view('namespaces.show', ['namespace' => $data, 'json' => $json]);
        } catch (GuzzleException | \Exception $e) {
            Log::error("Error fetching namespace details: " . $e->getMessage());
            return view('namespaces.show', ['conn_error' => $e->getMessage()]);
        }
    }
    
    /**
     * Extract namespace details from API response
     * 
     * @param array $jsonData
     * @return array
     */
    private function extractNamespaceDetails(array $jsonData): array
    {
        $metadata = $jsonData['metadata'] ?? [];
        $spec = $jsonData['spec'] ?? [];
        $status = $jsonData['status'] ?? [];
        
        return [
            // Metadata
            'name' => $metadata['name'] ?? '',
            'uid' => $metadata['uid'] ?? '',
            'creationTimestamp' => $metadata['creationTimestamp'] ?? '',
            'resourceVersion' => $metadata['resourceVersion'] ?? '',
            'labels' => $metadata['labels'] ?? [],
            'annotations' => $metadata['annotations'] ?? [],
            
            // Spec
            'finalizers' => $spec['finalizers'] ?? [],
            
            // Status
            'status' => $status['phase'] ?? 'Unknown',
        ];
    }
    
    /**
     * Show the form for creating a new namespace
     * 
     * @return View
     */
    public function create(): View
    {
        return view("namespaces.create");
    }

    /**
     * Store a newly created namespace
     * 
     * @param NamespaceRequest $request
     * @return RedirectResponse
     */
    public function store(NamespaceRequest $request): RedirectResponse
    {
        try {
            $formData = $request->validated();
            $namespaceData = $this->buildNamespaceData($formData);
            $jsonData = json_encode($namespaceData);

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

            $client->post("/api/v1/namespaces");

            return redirect()->route('Namespaces.index')
                ->with('success-msg', "Namespace '{$formData['name']}' was added successfully");
        } catch (GuzzleException $e) {
            Log::error("Error creating namespace: " . $e->getMessage());
            $errorMsg = $this->parseErrorResponse($e);
            return redirect()->back()->withInput()->with('error_msg', $errorMsg);
        } catch (\Exception $e) {
            Log::error("Unexpected error creating namespace: " . $e->getMessage());
            $errorMsg = $this->parseErrorMessage($e->getMessage());
            return redirect()->back()->withInput()->with('error_msg', $errorMsg);
        }
    }

    /**
     * Build namespace data structure from form data
     * 
     * @param array $formData
     * @return array
     */
    private function buildNamespaceData(array $formData): array
    {
        $data = [
            'apiVersion' => "v1",
            'kind' => "Namespace",
            'metadata' => [
                'name' => $formData['name']
            ],
            'spec' => [
                'finalizers' => ['kubernetes']
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

        // Add additional finalizers if provided
        if (isset($formData['finalizers'])) {
            foreach ($formData['finalizers'] as $finalizer) {
                $data['spec']['finalizers'][] = $finalizer;
            }
        }
        
        return $data;
    }

    /**
     * Remove a namespace
     * 
     * @param string $id Namespace name
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->client->delete("/api/v1/namespaces/" . $id);

            return redirect()->route('Namespaces.index')
                ->with('success-msg', "Namespace '{$id}' was deleted successfully");
        } catch (GuzzleException $e) {
            Log::error("Error deleting namespace: " . $e->getMessage());
            $errorMsg = $this->parseErrorResponse($e);
            return redirect()->back()->with('error_msg', $errorMsg);
        } catch (\Exception $e) {
            Log::error("Unexpected error deleting namespace: " . $e->getMessage());
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
