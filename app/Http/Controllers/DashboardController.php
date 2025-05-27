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

        return view('dashboard.index', ['events' => $events, 'nodes' => $nodes, 'resources' => $resources]);
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
