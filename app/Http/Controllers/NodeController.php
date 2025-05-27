<?php

namespace App\Http\Controllers;

use App\Exceptions\ClusterConnectionException;
use App\Exceptions\ClusterException;
use App\Models\Cluster;
use Illuminate\View\View;
use GuzzleHttp\Client;

class NodeController extends Controller
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

    public function index(): View
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
                $data['name'] = $nodeData['metadata']['name'];

                // Hostname (pode ser o mesmo que o nome)
                $data['hostname'] = $nodeData['metadata']['labels']['kubernetes.io/hostname'] ?? $nodeData['metadata']['name'];

                // Arquitetura e OS
                $data['arch'] = ($nodeData['metadata']['labels']['kubernetes.io/os'] ?? 'linux') .
                    " (" . ($nodeData['metadata']['labels']['kubernetes.io/arch'] ?? 'amd64') . ")";

                // Verifica se é master
                $data['master'] = isset($nodeData['metadata']['labels']['node-role.kubernetes.io/master']) ||
                    isset($nodeData['metadata']['labels']['node.kubernetes.io/microk8s-controlplane']) ?
                    "true" : "false";

                // Tipo de instância (usando microk8s labels)
                $data['instance'] = $nodeData['metadata']['labels']['node.kubernetes.io/microk8s-worker'] ??
                    $nodeData['metadata']['labels']['node.kubernetes.io/microk8s-controlplane'] ??
                    'unknown';

                // CIDR dos pods
                $data['podCidr'] = $nodeData['spec']['podCIDRs'][0] ?? 'Not assigned';

                // Status (Ready)
                $data['status'] = 'False';
                foreach ($nodeData['status']['conditions'] as $condition) {
                    if ($condition['type'] === 'Ready') {
                        $data['status'] = $condition['status'];
                        break;
                    }
                }

                // Sistema operacional
                $data['os'] = $nodeData['status']['nodeInfo']['osImage'] ?? 'Unknown OS';

                // IP do node
                $data['ip'] = 'Unknown IP';
                foreach ($nodeData['status']['addresses'] as $address) {
                    if ($address['type'] === 'InternalIP') {
                        $data['ip'] = $address['address'];
                        break;
                    }
                }

                // CPUs e Memória
                $data['cpus'] = $nodeData['status']['capacity']['cpu'] ?? '?';
                $memory = $nodeData['status']['capacity']['memory'] ?? '0Ki';
                $data['memory'] = round((int)str_replace('Ki', '', $memory) / 1024 / 1024, 1); // Convertendo para GB

                $nodes[] = $data;
            }

            return view('nodes.index', ['nodes' => $nodes, 'conn_error' => null]);
        } catch (\Exception $e) {
            return view('nodes.index', ['nodes' => [], 'conn_error' => $e->getMessage()]);
        }
    }
}
