<?php

namespace App\Http\Controllers;

use App\Exceptions\ClusterConnectionException;
use App\Exceptions\ClusterException;
use App\Http\Requests\ServiceRequest;
use App\Models\Cluster;
use Illuminate\Http\RedirectResponse;
use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ServiceController extends Controller
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

    private function checkConnection($cluster) {
        
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
                        'Authorization' => "Bearer ". $cluster['token'],
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

            $response = $client->get("/api/v1/services");

            $jsonData = json_decode($response->getBody(), true);
            
            $services = [];
            
            foreach ($jsonData['items'] as $jsonData) {
                $data['name'] =  $jsonData['metadata']['name'];
                $data['namespace'] =  $jsonData['metadata']['namespace'];
                $data['ports'] =  count($jsonData['spec']['ports']);
                $data['selector'] =  isset($jsonData['spec']['selector']) ? $jsonData['spec']['selector'] : "-";
                $data['type'] =  $jsonData['spec']['type'];

                $services[] = $data;
            }

            //FILTERS
            $namespaceList = [];
            foreach ($services as $key => $service) {
                if ($request->query('showDefault') != "true") {
                    if (!preg_match('/^kube-/', $service['namespace']))
                    array_push($namespaceList,$service['namespace']);
                } else {
                    array_push($namespaceList,$service['namespace']);
                }
            }

            if ($request->query('showNamespaceData') && $request->query('showNamespaceData') != "All") {
                foreach ($services as $key => $service) {
                    if ($service['namespace'] != $request->query('showNamespaceData')) 
                    {
                        unset($services[$key]);
                    }
                }
            }
            $namespaceList = array_unique($namespaceList);

            if ($request->query('showDefault') != "true") {
                foreach ($services as $key => $service) {
                    if (preg_match('/^kube-/', $service['namespace'])) 
                    {
                        unset($services[$key]);
                    }
                }
            }

            return view('services.index', ['services' => $services, 'namespaceList' => $namespaceList]);
        } catch (\Exception $e) {
            return view('services.index', ['conn_error' => $e->getMessage()]);
        }
    }

    public function show($namespace, $id): View
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

            $response = $client->get("/api/v1/namespaces/$namespace/services/$id");

            $jsonData = json_decode($response->getBody(), true);
            unset($jsonData['metadata']['managedFields']);
            $json = json_encode($jsonData, JSON_PRETTY_PRINT);
            
            $data = [];
            // METADATA
            $data['name'] = isset($jsonData['metadata']['name']) ? $jsonData['metadata']['name'] : '';
            $data['namespace'] = isset($jsonData['metadata']['namespace']) ? $jsonData['metadata']['namespace'] : '';
            $data['uid'] = isset($jsonData['metadata']['uid']) ? $jsonData['metadata']['uid'] : '';
            $data['creationTimestamp'] = isset($jsonData['metadata']['creationTimestamp']) ? $jsonData['metadata']['creationTimestamp'] : '';
            $data['labels'] = isset($jsonData['metadata']['labels']) ? $jsonData['metadata']['labels'] : null;
            $data['annotations'] = isset($jsonData['metadata']['annotations']) ? $jsonData['metadata']['annotations'] : null;
            
            // SPEC
            $data['ports'] = isset($jsonData['spec']['ports']) ? $jsonData['spec']['ports'] : null;
            $data['selector'] = isset($jsonData['spec']['selector']) ? $jsonData['spec']['selector'] : null;
            $data['type'] = isset($jsonData['spec']['type']) ? $jsonData['spec']['type'] : '';
            $data['sessionAffinity'] = isset($jsonData['spec']['sessionAffinity']) ? $jsonData['spec']['sessionAffinity'] : '';
            $data['externalTrafficPolicy'] = isset($jsonData['spec']['externalTrafficPolicy']) ? $jsonData['spec']['externalTrafficPolicy'] : '';
            
            return view('services.show', ['service' => $data, 'json' => $json]);
        } catch (\Exception $e) {
            return view('services.show', ['conn_error' => $e->getMessage()]);
        }
    }
    
    public function create(): View 
    {
        return view("services.create");
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        try {
            $formData = $request->validated();
            
            // MAIN INFO
            $data['apiVersion'] = "v1";
            $data['kind'] = "Service";
            $data['metadata']['name'] = $formData['name'];
            $data['metadata']['namespace'] = $formData['namespace'];

            // LABELS & ANNOTATIONS
            if (isset($formData['key_labels']) && isset($formData['value_labels'])) {
                foreach ($formData['key_labels'] as $key => $label) {
                    $data['metadata']['labels'][$formData['key_labels'][$key]] = $formData['value_labels'][$key];
                }
            }

            if (isset($formData['key_annotations']) && isset($formData['value_annotations'])) {
                foreach ($formData['key_annotations'] as $key => $annotation) {
                    $data['metadata']['annotations'][$formData['key_annotations'][$key]] = $formData['value_annotations'][$key];
                }
            }

            //SELECTOR
            if (isset($formData['key_selectorLabels']) && isset($formData['value_selectorLabels'])) {
                foreach ($formData['key_selectorLabels'] as $key => $selector) {
                    $data['spec']['selector'][$formData['key_selectorLabels'][$key]] = $formData['value_selectorLabels'][$key];
                }
            }

            // PORTS
            $data['spec']['ports'] = [];
            if (isset($formData['portName']) && isset($formData['protocol']) && isset($formData['port']) && isset($formData['target']) && isset($formData['nodePort'])) {
                $arr_port = [];
                foreach ($formData['portName'] as $key => $port) {
                    $arr_port['name'] = $formData['portName'][$key];
                    $arr_port['protocol'] = $formData['protocol'][$key];
                    $arr_port['port'] = intval($formData['port'][$key]);
                    $arr_port['targetPort'] = intval($formData['target'][$key]);
                    if ($formData['protocol'] != 'ClusterIP')
                        $arr_port['nodePort'] = intval($formData['nodePort'][$key]);

                    array_push($data['spec']['ports'],$arr_port);
                }
            }
            

            // EXTRA INFO
            if (isset($formData['type'])  && $formData['type'] != "Auto") {
                $data['spec']['type'] = $formData['type'];
            }

            if (isset($formData['type']) && isset($formData['externalName'])) {
                $data['spec']['externalName'] = $formData['externalName'];
            }

            if (isset($formData['externalTrafficPolicy'])  && $formData['externalTrafficPolicy'] != "Auto") {
                $data['spec']['externalTrafficPolicy'] = $formData['externalTrafficPolicy'];
            }

            if (isset($formData['sessionAffinity']) && $formData['sessionAffinity'] != "Auto") {
                $data['spec']['sessionAffinity'] = $formData['sessionAffinity'];
            }

            if (isset($formData['sessionAffinity']) && isset($formData['sessionAffinityConfig'])  && $formData['sessionAffinity'] != "Auto") {
                $data['spec']['sessionAffinityConfig']['clientIP']['timeoutSeconds'] = intval($formData['sessionAffinityTimeoutSeconds']);
            }
            

            $jsonData = json_encode($data);


            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'body' => $jsonData,
                'verify' => false,
                'timeout' => $this->timeout
            ]);

            $response = $client->post("/api/v1/namespaces/".$formData['namespace']."/services");

            return redirect()->route('Services.index')->with('success-msg', "Service '". $formData['name'] ."' was added with success on Namespace '". $formData['namespace']."'");
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            
            $errormsg = $this->treat_error($e->getResponse()->getBody()->getContents());
            
            if ($errormsg == null) {
                return redirect()->back()->withInput()->with('error_msg', $errormsg);
            }

            return redirect()->back()->withInput()->with('error_msg', $errormsg);
        } catch (\Exception $e) {
            $errormsg = $this->treat_error($e->getMessage());

            if ($errormsg == null) {
                $errormsg['message'] = $e->getMessage();
                $errormsg['status'] = "Internal Server Error";
                $errormsg['code'] = "500";
            }

            return redirect()->back()->withInput()->with('error_msg', $errormsg);
        }
    }

    public function destroy($namespace, $id) 
    {
        try {
            $client = new Client([
                'base_uri' => $this->endpoint,
                'headers' => [
                    'Authorization' => $this->token,
                ],
                'verify' => false,
                'timeout' => $this->timeout
            ]);
    
            $response = $client->delete("/api/v1/namespaces/$namespace/services/$id");

            return redirect()->route('Services.index')->with('success-msg', "Service '$id' was deleted with success");
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            
            $errormsg = $this->treat_error($e->getResponse()->getBody()->getContents());
            
            if ($errormsg == null) {
                return redirect()->back()->withInput()->with('error_msg', $errormsg);
            }

            return redirect()->back()->withInput()->with('error_msg', $errormsg);
        } catch (\Exception $e) {
            $errormsg = $this->treat_error($e->getMessage());

            if ($errormsg == null) {
                $errormsg['message'] = $e->getMessage();
                $errormsg['status'] = "Internal Server Error";
                $errormsg['code'] = "500";
            }

            return redirect()->back()->withInput()->with('error_msg', $errormsg);
        }
    }

    private function treat_error($errorMessage) 
    {
        $error = null;

        $jsonData = json_decode($errorMessage, true);

        if (isset($jsonData['message']))
            $error['message'] = $jsonData['message'];
        if (isset($jsonData['status']))
            $error['status'] = $jsonData['status'];
        if (isset($jsonData['code']))
            $error['code'] = $jsonData['code'];

        return $error;
    }
}
