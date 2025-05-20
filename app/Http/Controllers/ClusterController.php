<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClusterRequest;
use App\Models\Cluster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Utilizador não autenticado.');
        }

        // Garante que a variável $clusters é sempre uma Collection (mesmo se vazia)
        $clusters = $user->clusters ?? collect();

        if ($clusters->isNotEmpty()) {
            $promises = [];

            foreach ($clusters as $cluster) {
                $headers = [
                    'Accept' => 'application/json',
                ];

                if ($cluster['auth_type'] !== 'P') {
                    $headers['Authorization'] = "Bearer " . $cluster['token'];
                }

                $client = new Client([
                    'base_uri' => $cluster['endpoint'],
                    'headers' => $headers,
                    'verify' => false,
                    'timeout' => 0.5,
                ]);

                $promises[$cluster->id] = $client->getAsync("/api/v1");
            }

            // Espera pelas respostas assíncronas
            $responses = Promise\Utils::settle($promises)->wait();

            foreach ($clusters as $cluster) {
                $result = $responses[$cluster->id];

                if ($result['state'] === 'fulfilled') {
                    $cluster['online'] = $result['value']->getStatusCode();
                } else {
                    // Se falhou e é o cluster ativo na sessão, limpa a sessão
                    if ($cluster->id == session('clusterId')) {
                        session()->forget('clusterId');
                        session()->forget('clusterName');
                    }

                    $cluster['online'] = null;
                    $cluster['reason'] = $result['reason']->getCode() ?? 'Erro desconhecido';
                }
            }
        } else {
            // Se a coleção estiver vazia, define $clusters como null para a view
            $clusters = null;
        }

        return view("clusters.index", ['clusters' => $clusters]);
    }


    public function selectCluster($id): RedirectResponse
    {

        $cluster = Cluster::findOrFail($id);

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
            $online = null;
        }

        if (Auth::user()->id != $cluster->user_id || $online == null) {
            $errormsg['message'] = 'Could not use specified Cluster';
            $errormsg['status'] = 'Forbidden';
            $errormsg['code'] = '403';
            return redirect()->back()->withInput()->with('error_msg', $errormsg);
        }

        $errormsg['message'] = "Device ";
        $errormsg['status'] = 'Forbidden';
        $errormsg['code'] = '403';
        session(['clusterId' => $cluster['id']]);
        session(['clusterName' => $cluster['name']]);

        return redirect()->route('Dashboard')->with('success-msg', "Cluster '" . $cluster['name'] . "' selected with success");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("clusters.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClusterRequest $request): RedirectResponse
    {
        $formData = $request->validated();

        if (!isset($formData['timeout'])) {
            $formData['timeout'] = 5;
        }

        if ($formData['auth_type'] == 'T') {
            Cluster::create([
                'name' => $formData['name'],
                'endpoint' => $formData['endpoint'],
                'user_id' => Auth::user()->id,
                'auth_type' => $formData['auth_type'],
                'token' => $formData['token'],
                'timeout' => $formData['timeout'],
            ]);
        } else {
            Cluster::create([
                'name' => $formData['name'],
                'endpoint' => $formData['endpoint'],
                'user_id' => Auth::user()->id,
                'auth_type' => $formData['auth_type'],
                'timeout' => $formData['timeout'],
            ]);
        }

        return redirect()->route('Clusters.index')->with('success-msg', "A Cluster was added with success");
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        return view("clusters.show");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $cluster = Cluster::findOrFail($id);

        return view("clusters.edit", ['cluster' => $cluster]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClusterRequest $request, string $id): RedirectResponse
    {
        $formData = $request->validated();

        $cluster = Cluster::findOrFail($id);
        if (!isset($formData['timeout']))
            $formData['timeout'] = 5;

        $cluster->update($formData);

        return redirect()->route('Clusters.index')->withInput()->with('success-msg', $formData['name'] . " was updated with success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $cluster = Cluster::findOrFail($id);

        $cluster->delete();

        return redirect()->route('Clusters.index')->with('success-msg', "$cluster->name was deleted with success");
    }
}
