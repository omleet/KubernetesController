<?php

namespace App\Http\Controllers;

use App\Exceptions\ClusterConnectionException;
use App\Exceptions\ClusterException;
use App\Models\Cluster;
use Illuminate\Http\Request;
use Illuminate\View\View;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class DashboardController extends Controller
{
    private $endpoint;
    private $token;
    private $timeout;

    public function __construct()
    {
        if (!session('clusterId'))
            throw new ClusterException();

        $cluster = Cluster::findOrFail(session('clusterId'));

        if ($this->checkConnection($cluster) == -1)
            throw new ClusterConnectionException();

        $this->endpoint = $cluster['endpoint'];
        $this->token = "Bearer " . $cluster['token'];
        $this->timeout  = $cluster['timeout'];
    }

    private function checkConnection($cluster)
    {

        try {
            if ($cluster['auth_type'] == 'P') {
                $client = new Client([
                    'base_uri' => $cluster['endpoint'],
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'verify' => false,
                    'timeout' => 0.5
                ]);
            } else {
                $client = new Client([
                    'base_uri' => $cluster['endpoint'],
                    'headers' => [
                        'Authorization' => "Bearer " . $cluster['token'],
                        'Accept' => 'application/json',
                    ],
                    'verify' => false,
                    'timeout' => 0.5
                ]);
            }
            $response = $client->get("/api/v1");
            $online = $response->getStatusCode();
        } catch (\Exception $e) {
            $online = -1;
        }

        return $online;
    }

    public function index(Request $request): View
    {
        $events = $this->getEvents($request);
        $nodes = $this->getNodeInfo();
        $resources = $this->getTotalResources();
        $clusterInfo = $this->getClusterInfo();
        $persistentVolumes = $this->getPersistentVolumes();
        $resourceUsage = $this->getResourceUsage();
        $ingresses = $this->getIngressInfo();

        return view('dashboard.index', [
            'events' => $events, 
            'nodes' => $nodes, 
            'resources' => $resources,
            'clusterInfo' => $clusterInfo,
            'persistentVolumes' => $persistentVolumes,
            'resourceUsage' => $resourceUsage,
            'ingresses' => $ingresses
        ]);
    }

    private function getNodeInfo()
    {
        try {
            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'verify' => false,
                'timeout' => $this->timeout
            ]);

            $response = $client->get("/api/v1/nodes");
            $jsonData = json_decode($response->getBody(), true);

            $nodes = [];
            foreach ($jsonData['items'] as $nodeData) {
                $data = [];

                // Nome do node
                $data['name'] = $nodeData['metadata']['name'] ??
                    ($nodeData['metadata']['labels']['kubernetes.io/hostname'] ?? 'Unknown');

                // Verifica se é master
                $data['master'] = isset($nodeData['metadata']['labels']['node-role.kubernetes.io/master']) ||
                    isset($nodeData['metadata']['labels']['node.kubernetes.io/microk8s-controlplane']);

                // Sistema operacional
                $data['os'] = $nodeData['status']['nodeInfo']['osImage'] ?? 'Unknown OS';

                // IP do node
                $data['ip'] = 'Unknown IP';
                foreach ($nodeData['status']['addresses'] ?? [] as $address) {
                    if ($address['type'] === 'InternalIP') {
                        $data['ip'] = $address['address'];
                        break;
                    }
                }

                // CIDR dos pods
                $data['podCidr'] = $nodeData['spec']['podCIDRs'][0] ?? 'Not assigned';

                // CPUs
                $data['cpus'] = $nodeData['status']['capacity']['cpu'] ?? '?';

                // Arquitetura
                $data['arch'] = ($nodeData['metadata']['labels']['kubernetes.io/arch'] ??
                    ($nodeData['metadata']['labels']['beta.kubernetes.io/arch'] ?? 'unknown')) .
                    ' (' . ($nodeData['metadata']['labels']['kubernetes.io/os'] ?? 'linux') . ')';

                // Memória (convertendo para GB)
                $memory = $nodeData['status']['capacity']['memory'] ?? '0Ki';
                $data['memory'] = round((int)str_replace(['Ki', 'K'], '', $memory) / 1024 / 1024, 1); // Convertendo para GB

                // Status
                $data['status'] = 'False';
                foreach ($nodeData['status']['conditions'] ?? [] as $condition) {
                    if ($condition['type'] === 'Ready') {
                        $data['status'] = $condition['status'];
                        break;
                    }
                }

                $nodes[] = $data;
            }

            return $nodes;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getTotalResources()
    {
        try {
            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'verify' => false,
                'timeout' => 1
            ]);

            $promises = [
                'namespaces' => $client->getAsync("/api/v1/namespaces"),
                'pods' => $client->getAsync("/api/v1/pods"),
                'deployments' => $client->getAsync("/apis/apps/v1/deployments"),
                'services' => $client->getAsync("/api/v1/services"),
                'ingresses' => $client->getAsync("/apis/networking.k8s.io/v1/ingresses"),
            ];

            $responses = Promise\Utils::settle($promises)->wait();

            $totalResources = [];
            foreach ($responses as $key => $result) {
                if ($result['state'] === 'fulfilled') {
                    $jsonData = json_decode($result['value']->getBody(), true);
                    $totalResources[$key] = count($jsonData['items']);
                } else {
                    $totalResources[$key] = 0;
                }
            }

            return $totalResources;
        } catch (\Exception $e) {
            return null;
        }
    }
    
    private function getIngressInfo()
    {
        try {
            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'verify' => false,
                'timeout' => $this->timeout
            ]);

            $response = $client->get("/apis/networking.k8s.io/v1/ingresses");
            $jsonData = json_decode($response->getBody(), true);

            $ingresses = [];
            foreach ($jsonData['items'] as $ingressData) {
                $hosts = [];
                $paths = [];
                
                // Extract hosts and paths
                if (isset($ingressData['spec']['rules'])) {
                    foreach ($ingressData['spec']['rules'] as $rule) {
                        if (isset($rule['host'])) {
                            $hosts[] = $rule['host'];
                        }
                        
                        if (isset($rule['http']['paths'])) {
                            foreach ($rule['http']['paths'] as $path) {
                                $serviceName = $path['backend']['service']['name'] ?? 'unknown';
                                $servicePort = $path['backend']['service']['port']['number'] ?? 'unknown';
                                $pathType = $path['pathType'] ?? 'Prefix';
                                $pathValue = $path['path'] ?? '/';
                                
                                $paths[] = [
                                    'path' => $pathValue,
                                    'pathType' => $pathType,
                                    'serviceName' => $serviceName,
                                    'servicePort' => $servicePort
                                ];
                            }
                        }
                    }
                }
                
                // Get TLS info
                $tls = false;
                $tlsSecrets = [];
                if (isset($ingressData['spec']['tls']) && !empty($ingressData['spec']['tls'])) {
                    $tls = true;
                    foreach ($ingressData['spec']['tls'] as $tlsConfig) {
                        if (isset($tlsConfig['secretName'])) {
                            $tlsSecrets[] = $tlsConfig['secretName'];
                        }
                    }
                }
                
                $ingresses[] = [
                    'name' => $ingressData['metadata']['name'] ?? 'Unknown',
                    'namespace' => $ingressData['metadata']['namespace'] ?? 'default',
                    'hosts' => $hosts,
                    'paths' => $paths,
                    'tls' => $tls,
                    'tlsSecrets' => $tlsSecrets,
                    'creationTimestamp' => $ingressData['metadata']['creationTimestamp'] ?? 'Unknown',
                    'className' => $ingressData['spec']['ingressClassName'] ?? 'default'
                ];
            }

            return $ingresses;
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getClusterInfo()
    {
        try {
            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'verify' => false,
                'timeout' => $this->timeout
            ]);

            $response = $client->get("/version");
            $versionData = json_decode($response->getBody(), true);

            // Get cluster name from current context
            $configResponse = $client->get("/api/v1/namespaces/kube-system/configmaps/kubeadm-config");
            $configData = json_decode($configResponse->getBody(), true);
            $clusterName = $configData['data']['ClusterConfiguration'] ?? '';
            
            // Extract cluster name using regex if available
            $clusterNameMatch = [];
            preg_match('/clusterName:\s*([^\s]+)/', $clusterName, $clusterNameMatch);
            $clusterName = $clusterNameMatch[1] ?? 'Kubernetes Cluster';

            return [
                'version' => $versionData['gitVersion'] ?? 'Unknown',
                'buildDate' => $versionData['buildDate'] ?? 'Unknown',
                'platform' => $versionData['platform'] ?? 'Unknown',
                'goVersion' => $versionData['goVersion'] ?? 'Unknown',
                'name' => $clusterName
            ];
        } catch (\Exception $e) {
            // Fallback to basic version info if detailed info fails
            try {
                $client = new Client([
                    'base_uri' => $this->endpoint,
                    'headers' => [
                        'Authorization' => $this->token,
                        'Accept' => 'application/json',
                    ],
                    'verify' => false,
                    'timeout' => $this->timeout
                ]);

                $response = $client->get("/version");
                $versionData = json_decode($response->getBody(), true);

                return [
                    'version' => $versionData['gitVersion'] ?? 'Unknown',
                    'buildDate' => $versionData['buildDate'] ?? 'Unknown',
                    'platform' => $versionData['platform'] ?? 'Unknown',
                    'goVersion' => $versionData['goVersion'] ?? 'Unknown',
                    'name' => 'Kubernetes Cluster'
                ];
            } catch (\Exception $e) {
                return [
                    'version' => 'Unknown',
                    'buildDate' => 'Unknown',
                    'platform' => 'Unknown',
                    'goVersion' => 'Unknown',
                    'name' => 'Kubernetes Cluster'
                ];
            }
        }
    }

    private function getPersistentVolumes()
    {
        try {
            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'verify' => false,
                'timeout' => $this->timeout
            ]);

            $response = $client->get("/api/v1/persistentvolumes");
            $jsonData = json_decode($response->getBody(), true);

            $volumes = [];
            foreach ($jsonData['items'] as $volumeData) {
                $volumes[] = [
                    'name' => $volumeData['metadata']['name'] ?? 'Unknown',
                    'capacity' => $volumeData['spec']['capacity']['storage'] ?? 'Unknown',
                    'accessModes' => $volumeData['spec']['accessModes'] ?? [],
                    'status' => $volumeData['status']['phase'] ?? 'Unknown',
                    'storageClass' => $volumeData['spec']['storageClassName'] ?? 'standard',
                    'claim' => isset($volumeData['spec']['claimRef']) ? 
                        ($volumeData['spec']['claimRef']['namespace'] . '/' . $volumeData['spec']['claimRef']['name']) : 'None'
                ];
            }

            return $volumes;
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getResourceUsage()
    {
        try {
            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'verify' => false,
                'timeout' => $this->timeout
            ]);

            // Get metrics API if available
            try {
                $metricsResponse = $client->get("/apis/metrics.k8s.io/v1beta1/nodes");
                $metricsData = json_decode($metricsResponse->getBody(), true);
                
                $nodeMetrics = [];
                foreach ($metricsData['items'] as $nodeMetric) {
                    $nodeName = $nodeMetric['metadata']['name'];
                    $cpuUsage = $nodeMetric['usage']['cpu'];
                    $memoryUsage = $nodeMetric['usage']['memory'];
                    
                    // Convert CPU usage from nanocores to cores
                    $cpuUsage = str_replace('n', '', $cpuUsage);
                    $cpuUsage = (float)$cpuUsage / 1000000000;
                    
                    // Convert memory usage to MB
                    $memoryUsage = str_replace('Ki', '', $memoryUsage);
                    $memoryUsage = (int)$memoryUsage / 1024;
                    
                    $nodeMetrics[$nodeName] = [
                        'cpuUsage' => round($cpuUsage, 2),
                        'memoryUsage' => round($memoryUsage, 0)
                    ];
                }
                
                return [
                    'hasMetrics' => true,
                    'nodeMetrics' => $nodeMetrics
                ];
            } catch (\Exception $e) {
                // Metrics API not available
                return [
                    'hasMetrics' => false,
                    'nodeMetrics' => []
                ];
            }
        } catch (\Exception $e) {
            return [
                'hasMetrics' => false,
                'nodeMetrics' => []
            ];
        }
    }

    private function getEvents(Request $request)
    {
        try {
            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'verify' => false,
                'timeout' => $this->timeout
            ]);

            $response = $client->get("/api/v1/events");
            $jsonData = json_decode($response->getBody(), true);

            $allEvents = [];
            foreach ($jsonData['items'] as $eventData) {
                try {
                    $allEvents[] = [
                        'kind' => $eventData['involvedObject']['kind'] ?? 'Unknown',
                        'name' => $eventData['involvedObject']['name'] ?? 'Unknown',
                        'namespace' => $eventData['involvedObject']['namespace'] ?? '-',
                        'type' => $eventData['type'] ?? 'Unknown',
                        'time' => $eventData['eventTime'] ?? null,
                        'startTime' => $eventData['firstTimestamp'] ?? null,
                        'endTime' => $eventData['lastTimestamp'] ?? null,
                        'message' => $eventData['message'] ?? '-'
                    ];
                } catch (\Throwable $th) {
                    continue;
                }
            }

            // Ordenar eventos pelos mais recentes primeiro
            usort($allEvents, function ($a, $b) {
                $timeA = $a['time'] ?? $a['startTime'] ?? '';
                $timeB = $b['time'] ?? $b['startTime'] ?? '';
                return strtotime($timeB) - strtotime($timeA);
            });

            // Paginação manual
            $page = $request->get('page', 1);
            $perPage = 10;
            $offset = ($page - 1) * $perPage;
            $paginatedEvents = array_slice($allEvents, $offset, $perPage);

            return [
                'data' => $paginatedEvents,
                'total' => count($allEvents),
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil(count($allEvents) / $perPage)
            ];
        } catch (\Exception $e) {
           
            return null;
        }
    }
}
