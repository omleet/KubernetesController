<?php

namespace App\Http\Controllers;

use App\Exceptions\ClusterConnectionException;
use App\Exceptions\ClusterException;
use App\Http\Requests\IngressRequest;
use App\Models\Cluster;
use Illuminate\Http\RedirectResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\View\View;
use Illuminate\Http\Request;

class IngressController extends Controller
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
     * Display a listing of ingresses
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $response = $this->client->get("/apis/networking.k8s.io/v1/ingresses");
            $jsonData = json_decode($response->getBody(), true);
            
            $ingresses = $this->processIngressesData($jsonData['items']);
            $namespaceList = $this->extractNamespaces($ingresses, $request->query('showDefault') === "true");
            
            // Apply namespace filter if specified
            if ($request->query('showNamespaceData') && $request->query('showNamespaceData') !== "All") {
                $ingresses = array_filter($ingresses, function($ingress) use ($request) {
                    return $ingress['namespace'] === $request->query('showNamespaceData');
                });
            }
            
            // Filter out kube- namespaces if not showing defaults
            if ($request->query('showDefault') !== "true") {
                $ingresses = array_filter($ingresses, function($ingress) {
                    return !preg_match('/^kube-/', $ingress['namespace']);
                });
            }

            return view('ingresses.index', [
                'ingresses' => array_values($ingresses), // Reset array keys
                'namespaceList' => $namespaceList
            ]);
        } catch (\Exception $e) {
            return view('ingresses.index', ['conn_error' => $e->getMessage()]);
        }
    }

    /**
     * Process raw ingresses data into a structured format
     * 
     * @param array $items Raw ingress items from API
     * @return array Processed ingresses data
     */
    private function processIngressesData(array $items): array
    {
        $ingresses = [];
        
        foreach ($items as $item) {
            $data = [
                'name' => $item['metadata']['name'],
                'namespace' => $item['metadata']['namespace'],
                'services' => [],
                'ingressIP' => isset($item['status']['loadBalancer']['ingress']) 
                    ? $item['status']['loadBalancer']['ingress'] 
                    : '-'
            ];
            
            if (isset($item['spec']['rules'])) {
                $serviceIndex = 0;
                foreach ($item['spec']['rules'] as $rule) {
                    if (isset($rule['http']['paths'])) {
                        foreach ($rule['http']['paths'] as $path) {
                            $serviceData = [
                                'path' => $path['path'],
                                'type' => $path['pathType'],
                            ];
                            
                            foreach ($path['backend'] as $backend) {
                                $serviceData['serviceName'] = $backend['name'];
                                $serviceData['port'] = $backend['port']['number'];
                            }
                            
                            $data['services'][$serviceIndex] = $serviceData;
                            $serviceIndex++;
                        }
                    }
                }
            }
            
            $ingresses[] = $data;
        }
        
        return $ingresses;
    }

    /**
     * Extract unique namespaces from ingresses
     * 
     * @param array $ingresses List of ingresses
     * @param bool $includeKubeNamespaces Whether to include kube- namespaces
     * @return array List of unique namespaces
     */
    private function extractNamespaces(array $ingresses, bool $includeKubeNamespaces): array
    {
        $namespaceList = [];
        
        foreach ($ingresses as $ingress) {
            if ($includeKubeNamespaces || !preg_match('/^kube-/', $ingress['namespace'])) {
                $namespaceList[] = $ingress['namespace'];
            }
        }
        
        return array_unique($namespaceList);
    }

    /**
     * Display the specified ingress
     * 
     * @param string $namespace
     * @param string $id
     * @return View
     */
    public function show(string $namespace, string $id): View
    {
        try {
            $response = $this->client->get("/apis/networking.k8s.io/v1/namespaces/$namespace/ingresses/$id");
            $jsonData = json_decode($response->getBody(), true);
            
            // Remove managed fields to clean up the JSON output
            unset($jsonData['metadata']['managedFields']);
            $json = json_encode($jsonData, JSON_PRETTY_PRINT);
            
            $data = $this->extractIngressDetails($jsonData);
            
            return view('ingresses.show', ['ingress' => $data, 'json' => $json]);
        } catch (\Exception $e) {
            return view('ingresses.show', ['conn_error' => $e->getMessage()]);
        }
    }
    
    /**
     * Extract ingress details from API response
     * 
     * @param array $jsonData Raw ingress data
     * @return array Structured ingress details
     */
    private function extractIngressDetails(array $jsonData): array
    {
        $data = [
            // METADATA
            'name' => $jsonData['metadata']['name'] ?? '',
            'namespace' => $jsonData['metadata']['namespace'] ?? '',
            'uid' => $jsonData['metadata']['uid'] ?? '',
            'creationTimestamp' => $jsonData['metadata']['creationTimestamp'] ?? '',
            'labels' => $jsonData['metadata']['labels'] ?? null,
            'annotations' => $jsonData['metadata']['annotations'] ?? null,
            
            // SPEC
            'defaultBackendName' => $jsonData['spec']['defaultBackend']['service']['name'] ?? null,
            'defaultBackendPort' => $jsonData['spec']['defaultBackend']['service']['port']['number'] ?? null,
            'rules' => $jsonData['spec']['rules'] ?? null,
        ];
        
        return $data;
    }
    
    /**
     * Show the form for creating a new ingress
     * 
     * @return View
     */
    public function create(): View 
    {
        return view("ingresses.create");
    }

    /**
     * Store a newly created ingress
     * 
     * @param IngressRequest $request
     * @return RedirectResponse
     */
    public function store(IngressRequest $request): RedirectResponse
    {
        try {
            $formData = $request->validated();
            $data = $this->prepareIngressData($formData);
            $jsonData = json_encode($data);
            
            $this->client->post(
                "/apis/networking.k8s.io/v1/namespaces/{$formData['namespace']}/ingresses",
                ['body' => $jsonData]
            );

            return redirect()
                ->route('Ingresses.index')
                ->with('success-msg', "Ingress '{$formData['name']}' was added with success on Namespace '{$formData['namespace']}'");
        } catch (RequestException $e) {
            $errorMsg = $this->treatError($e->getResponse()->getBody()->getContents());
            return $this->handleError($errorMsg);
        } catch (\Exception $e) {
            $errorMsg = $this->treatError($e->getMessage());
            
            if ($errorMsg === null) {
                $errorMsg = [
                    'message' => $e->getMessage(),
                    'status' => "Internal Server Error",
                    'code' => "500"
                ];
            }
            
            return $this->handleError($errorMsg);
        }
    }
    
    /**
     * Prepare ingress data from form input
     * 
     * @param array $formData Validated form data
     * @return array Structured ingress data for API
     */
    private function prepareIngressData(array $formData): array
    {
        $data = [
            'apiVersion' => "networking.k8s.io/v1",
            'kind' => "Ingress",
            'metadata' => [
                'name' => $formData['name'],
                'namespace' => $formData['namespace']
            ],
            'spec' => []
        ];

        // Add labels if provided
        if (isset($formData['key_labels']) && isset($formData['value_labels'])) {
            $data['metadata']['labels'] = array_combine(
                $formData['key_labels'],
                $formData['value_labels']
            );
        }

        // Add annotations if provided
        if (isset($formData['key_annotations']) && isset($formData['value_annotations'])) {
            $data['metadata']['annotations'] = array_combine(
                $formData['key_annotations'],
                $formData['value_annotations']
            );
        }

        // Process rules
        if (isset($formData['rules'])) {
            $rules = [];
            foreach ($formData['rules'] as $rule) {
                $arrRule = [];
                
                // Add host if provided
                if (isset($rule['host'])) {
                    $arrRule['host'] = $rule['host'];
                }
                
                // Process paths
                $paths = [];
                foreach ($rule['path']['pathName'] as $keyPathName => $pathName) {
                    $paths[] = [
                        'path' => $pathName,
                        'pathType' => $rule['path']['pathType'][$keyPathName],
                        'backend' => [
                            'service' => [
                                'name' => $rule['path']['serviceName'][$keyPathName],
                                'port' => [
                                    'number' => intval($rule['path']['portNumber'][$keyPathName])
                                ]
                            ]
                        ]
                    ];
                }
                
                $arrRule['http']['paths'] = $paths;
                $rules[] = $arrRule;
            }
            
            $data['spec']['rules'] = $rules;
        }
        
        // Add default backend if provided
        if (isset($formData['defaultBackendName']) && isset($formData['defaultBackendPort'])) {
            $data['spec']['defaultBackend'] = [
                'service' => [
                    'name' => $formData['defaultBackendName'],
                    'port' => [
                        'number' => intval($formData['defaultBackendPort'])
                    ]
                ]
            ];
        }
        
        return $data;
    }

    /**
     * Remove the specified ingress
     * 
     * @param string $namespace
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $namespace, string $id): RedirectResponse
    {
        try {
            $this->client->delete("/apis/networking.k8s.io/v1/namespaces/$namespace/ingresses/$id");

            return redirect()
                ->route('Ingresses.index')
                ->with('success-msg', "Ingress '$id' was deleted with success");
        } catch (RequestException $e) {
            $errorMsg = $this->treatError($e->getResponse()->getBody()->getContents());
            return $this->handleError($errorMsg);
        } catch (\Exception $e) {
            $errorMsg = $this->treatError($e->getMessage());
            
            if ($errorMsg === null) {
                $errorMsg = [
                    'message' => $e->getMessage(),
                    'status' => "Internal Server Error",
                    'code' => "500"
                ];
            }
            
            return $this->handleError($errorMsg);
        }
    }

    /**
     * Handle error response
     * 
     * @param array|null $errorMsg
     * @return RedirectResponse
     */
    private function handleError(?array $errorMsg): RedirectResponse
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error_msg', $errorMsg);
    }

    /**
     * Process error message from API response
     * 
     * @param string $errorMessage Raw error message
     * @return array|null Structured error data
     */
    private function treatError(string $errorMessage): ?array
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
            $error['status'] = $jsonData['status'] . (isset($jsonData['reason']) ? "({$jsonData['reason']})" : "");
        }
        
        if (isset($jsonData['code'])) {
            $error['code'] = $jsonData['code'];
        }
        
        return empty($error) ? null : $error;
    }
}
