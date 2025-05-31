<?php

namespace App\Http\Controllers;

use App\Exceptions\ClusterConnectionException;
use App\Exceptions\ClusterException;
use App\Models\Cluster;
use Illuminate\View\View;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class NodeController extends Controller
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
     * Display a listing of the nodes
     * 
     * @return View
     */
    public function index(): View
    {
        try {
            $response = $this->client->get("/api/v1/nodes");
            $jsonData = json_decode($response->getBody(), true);

            $nodes = $this->processNodeData($jsonData['items'] ?? []);
            
            return view('nodes.index', ['nodes' => $nodes, 'conn_error' => null]);
        } catch (GuzzleException | \Exception $e) {
            Log::error("Error fetching nodes: " . $e->getMessage());
            return view('nodes.index', ['nodes' => [], 'conn_error' => $e->getMessage()]);
        }
    }
    
    /**
     * Display the specified node
     *
     * @param string $name Node name
     * @return View
     */
    public function show(string $name): View
    {
        try {
            $response = $this->client->get("/api/v1/nodes/{$name}");
            $nodeData = json_decode($response->getBody(), true);
            
            // Process the node data
            $nodes = $this->processNodeData([$nodeData]);
            $node = !empty($nodes) ? $nodes[0] : null;
            
            // Get additional details for the detailed view
            if ($node) {
                // Add any additional node details you want to display
                $node['creationTimestamp'] = $nodeData['metadata']['creationTimestamp'] ?? 'Unknown';
                
                // Get node conditions
                $node['conditions'] = [];
                foreach ($nodeData['status']['conditions'] ?? [] as $condition) {
                    $node['conditions'][] = [
                        'type' => $condition['type'] ?? 'Unknown',
                        'status' => $condition['status'] ?? 'Unknown',
                        'lastTransitionTime' => $condition['lastTransitionTime'] ?? 'Unknown',
                        'reason' => $condition['reason'] ?? 'Unknown',
                        'message' => $condition['message'] ?? 'Unknown'
                    ];
                }
                
                // Get node capacity and allocatable resources
                $node['capacity'] = $nodeData['status']['capacity'] ?? [];
                $node['allocatable'] = $nodeData['status']['allocatable'] ?? [];
                
                // Get node images
                $node['images'] = [];
                foreach ($nodeData['status']['images'] ?? [] as $image) {
                    $node['images'][] = [
                        'names' => $image['names'] ?? [],
                        'sizeBytes' => $image['sizeBytes'] ?? 0
                    ];
                }
            }
            
            return view('nodes.show', ['node' => $node, 'conn_error' => null]);
        } catch (GuzzleException | \Exception $e) {
            Log::error("Error fetching node details: " . $e->getMessage());
            return view('nodes.show', ['node' => null, 'conn_error' => $e->getMessage()]);
        }
    }
    
    /**
     * Process node data from Kubernetes API
     * 
     * @param array $nodesData
     * @return array
     */
    private function processNodeData(array $nodesData): array
    {
        $nodes = [];
        
        foreach ($nodesData as $nodeData) {
            $metadata = $nodeData['metadata'] ?? [];
            $spec = $nodeData['spec'] ?? [];
            $status = $nodeData['status'] ?? [];
            $labels = $metadata['labels'] ?? [];
            
            $nodes[] = [
                // Basic node information
                'name' => $metadata['name'] ?? 'Unknown',
                'hostname' => $labels['kubernetes.io/hostname'] ?? $metadata['name'] ?? 'Unknown',
                
                // Architecture and OS
                'arch' => ($labels['kubernetes.io/os'] ?? 'linux') . 
                    " (" . ($labels['kubernetes.io/arch'] ?? 'amd64') . ")",
                
                // Master/worker role
                'master' => (isset($labels['node-role.kubernetes.io/master']) || 
                    isset($labels['node.kubernetes.io/microk8s-controlplane'])) ? 
                    "true" : "false",
                
                // Instance type
                'instance' => $labels['node.kubernetes.io/microk8s-worker'] ?? 
                    $labels['node.kubernetes.io/microk8s-controlplane'] ?? 
                    'unknown',
                
                // Pod CIDR information
                'podCIDRs' => $spec['podCIDRs'] ?? 
                    (isset($spec['podCIDR']) ? [$spec['podCIDR']] : ['Not assigned']),
                
                // Node status
                'status' => $this->getNodeReadyStatus($status['conditions'] ?? []),
                
                // OS information
                'os' => $status['nodeInfo']['osImage'] ?? 'Unknown OS',
                
                // IP address
                'ip' => $this->getNodeInternalIP($status['addresses'] ?? []),
                
                // Resources
                'cpus' => $status['capacity']['cpu'] ?? '?',
                'memory' => $this->convertMemoryToGB($status['capacity']['memory'] ?? '0Ki')
            ];
        }
        
        return $nodes;
    }
    
    /**
     * Get node ready status from conditions
     * 
     * @param array $conditions
     * @return string
     */
    private function getNodeReadyStatus(array $conditions): string
    {
        foreach ($conditions as $condition) {
            if ($condition['type'] === 'Ready') {
                return $condition['status'];
            }
        }
        
        return 'False';
    }
    
    /**
     * Get node internal IP address
     * 
     * @param array $addresses
     * @return string
     */
    private function getNodeInternalIP(array $addresses): string
    {
        foreach ($addresses as $address) {
            if ($address['type'] === 'InternalIP') {
                return $address['address'];
            }
        }
        
        return 'Unknown IP';
    }
    
    /**
     * Convert Kubernetes memory string to GB
     * 
     * @param string $memory
     * @return float
     */
    private function convertMemoryToGB(string $memory): float
    {
        return round((int)str_replace('Ki', '', $memory) / 1024 / 1024, 1);
    }
}
