<?php

namespace App\Http\Controllers;

use App\Exceptions\ClusterConnectionException;
use App\Exceptions\ClusterException;
use App\Http\Requests\CustomResourceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Cluster;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CustomResourceController extends Controller
{
    private string $endpoint;
    private string $token;
    private int $timeout;
    private Client $client;

    /**
     * Constructor - initialize controller with cluster connection
     * 
     * @throws ClusterException
     * @throws ClusterConnectionException
     */
    public function __construct()
    {
        if (!session('clusterId')) {
            throw new ClusterException();
        }

        $cluster = Cluster::findOrFail(session('clusterId'));

        if ($this->checkConnection($cluster) == -1) {
            throw new ClusterConnectionException();
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
     * Check if the cluster is reachable
     * 
     * @param Cluster $cluster
     * @return int Status code or -1 if connection failed
     */
    private function checkConnection(Cluster $cluster): int
    {
        try {
            $clientOptions = [
                'base_uri' => $cluster['endpoint'],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'verify' => false,
                'timeout' => 0.5
            ];
            
            if ($cluster['auth_type'] !== 'P') {
                $clientOptions['headers']['Authorization'] = "Bearer " . $cluster['token'];
            }
            
            $client = new Client($clientOptions);
            $response = $client->get("/api/v1");
            
            return $response->getStatusCode();
        } catch (\Exception $e) {
            return -1;
        }
    }

    /**
     * Display the custom resource creation form
     * 
     * @return View
     */
    public function index(): View
    {
        return view('customresource.index');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param CustomResourceRequest $request
     * @return RedirectResponse
     */
    public function store(CustomResourceRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $data = json_decode($formData['resource'], true);

        // Validate JSON parsing
        if ($data === null) {
            return $this->createErrorResponse(
                "Could not parse JSON, syntax error",
                "Bad Request",
                "400"
            );
        }

        // Validate resource kind
        if (!isset($data['kind'])) {
            return $this->createErrorResponse(
                "Resource kind not found",
                "Bad Request",
                "400"
            );
        }

        // Get appropriate Kubernetes API endpoint
        $endpoint = $this->getKubernetesEndpoint(
            $data['kind'],
            $data['metadata']['namespace'] ?? null
        );

        if ($endpoint === -1) {
            return $this->createErrorResponse(
                "Could not find the correct endpoint for the specified resource",
                "Unprocessable Content",
                "422"
            );
        }

        try {
            // Send request to Kubernetes API
            $this->client->post($endpoint, ['body' => json_encode($data)]);
            
            // Create appropriate success message
            $successMessage = $this->createSuccessMessage($data);

            return redirect()
                ->route('CustomResources.index')
                ->withInput()
                ->with('success-msg', $successMessage);
        } catch (RequestException $e) {
            $errorMsg = $this->parseErrorResponse($e->getResponse()->getBody()->getContents());
            return redirect()->back()->withInput()->with('error_msg', $errorMsg);
        } catch (\Exception $e) {
            $errorMsg = $this->parseErrorResponse($e->getMessage());
            
            if ($errorMsg === null) {
                $errorMsg = [
                    'message' => $e->getMessage(),
                    'status' => "Internal Server Error",
                    'code' => "500"
                ];
            }
            
            return redirect()->back()->withInput()->with('error_msg', $errorMsg);
        }
    }

    /**
     * Create a success message based on the resource data
     * 
     * @param array $data Resource data
     * @return string Success message
     */
    private function createSuccessMessage(array $data): string
    {
        if (isset($data['metadata']['namespace']) && isset($data['metadata']['name'])) {
            return $data['kind'] . " '" . $data['metadata']['name'] . "' was added with success on Namespace '" . $data['metadata']['namespace'] . "'";
        } elseif (!isset($data['metadata']['namespace']) && isset($data['metadata']['name'])) {
            return $data['kind'] . " '" . $data['metadata']['name'] . "' was added with success";
        } else {
            return $data['kind'] . " was added with success";
        }
    }

    /**
     * Create an error response
     * 
     * @param string $message Error message
     * @param string $status Error status
     * @param string $code Error code
     * @return RedirectResponse
     */
    private function createErrorResponse(string $message, string $status, string $code): RedirectResponse
    {
        $errorMsg = [
            'message' => $message,
            'status' => $status,
            'code' => $code
        ];

        return redirect()->back()->withInput()->with('error_msg', $errorMsg);
    }

    /**
     * Get the appropriate Kubernetes API endpoint for a resource kind
     * 
     * @param string $resourceKind The kind of resource
     * @param string|null $namespace The namespace (if applicable)
     * @return string|int The API endpoint or -1 if not found
     */
    private function getKubernetesEndpoint(string $resourceKind, ?string $namespace = null)
    {
        // Map of resource kinds to their API endpoints
        $resourceEndpoints = [
            // Core API (v1)
            'Pod' => "/api/v1/namespaces/{$namespace}/pods",
            'Service' => "/api/v1/namespaces/{$namespace}/services",
            'ConfigMap' => "/api/v1/namespaces/{$namespace}/configmaps",
            'Secret' => "/api/v1/namespaces/{$namespace}/secrets",
            'PersistentVolume' => "/api/v1/persistentvolumes",
            'PersistentVolumeClaim' => "/api/v1/namespaces/{$namespace}/persistentvolumeclaims",
            'Namespace' => "/api/v1/namespaces",
            'Event' => "/api/v1/namespaces/{$namespace}/events",
            'Endpoint' => "/api/v1/namespaces/{$namespace}/endpoints",
            'ReplicationController' => "/api/v1/namespaces/{$namespace}/replicationcontrollers",
            'ServiceAccount' => "/api/v1/namespaces/{$namespace}/serviceaccounts",
            'ResourceQuota' => "/api/v1/namespaces/{$namespace}/resourcequotas",
            'LimitRange' => "/api/v1/namespaces/{$namespace}/limitranges",
            'PodTemplate' => "/api/v1/namespaces/{$namespace}/podtemplates",
            
            // Apps API (apps/v1)
            'Deployment' => "/apis/apps/v1/namespaces/{$namespace}/deployments",
            'StatefulSet' => "/apis/apps/v1/namespaces/{$namespace}/statefulsets",
            'DaemonSet' => "/apis/apps/v1/namespaces/{$namespace}/daemonsets",
            'ReplicaSet' => "/apis/apps/v1/namespaces/{$namespace}/replicasets",
    
            // Batch API (batch/v1)
            'Job' => "/apis/batch/v1/namespaces/{$namespace}/jobs",
            'CronJob' => "/apis/batch/v1/namespaces/{$namespace}/cronjobs",
    
            // Autoscaling API (autoscaling/v1, autoscaling/v2)
            'HorizontalPodAutoscaler' => "/apis/autoscaling/v1/namespaces/{$namespace}/horizontalpodautoscalers",
    
            // Networking API (networking.k8s.io/v1)
            'Ingress' => "/apis/networking.k8s.io/v1/namespaces/{$namespace}/ingresses",
            'NetworkPolicy' => "/apis/networking.k8s.io/v1/namespaces/{$namespace}/networkpolicies",
    
            // Policy API (policy/v1)
            'PodDisruptionBudget' => "/apis/policy/v1/namespaces/{$namespace}/poddisruptionbudgets",
    
            // Custom Resource Definitions (CRDs)
            'CustomResourceDefinition' => "/apis/apiextensions.k8s.io/v1/customresourcedefinitions",
    
            // Storage API (storage.k8s.io/v1)
            'StorageClass' => "/apis/storage.k8s.io/v1/storageclasses",
            'VolumeAttachment' => "/apis/storage.k8s.io/v1/volumeattachments",
    
            // Other APIs
            'APIService' => "/apis/apiregistration.k8s.io/v1/apiservices",
            'CertificateSigningRequest' => "/apis/certificates.k8s.io/v1/certificatesigningrequests",
            'PodSecurityPolicy' => "/apis/policy/v1beta1/podsecuritypolicies",
        ];

        return $resourceEndpoints[$resourceKind] ?? -1;
    }

    /**
     * Parse error response from Kubernetes API
     * 
     * @param string $errorMessage Raw error message
     * @return array|null Structured error data
     */
    private function parseErrorResponse(string $errorMessage): ?array
    {
        $jsonData = json_decode($errorMessage, true);
        
        if (!$jsonData) {
            return null;
        }
        
        $error = [];
        
        if (isset($jsonData['message'])) {
            $error['message'] = $jsonData['message'];
        }
        
        if (isset($jsonData['status'])) {
            $error['status'] = $jsonData['status'] . (isset($jsonData['reason']) ? " ({$jsonData['reason']})" : "");
        }
        
        if (isset($jsonData['code'])) {
            $error['code'] = $jsonData['code'];
        }
        
        return empty($error) ? null : $error;
    }
}
