<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class DeviceController extends Controller
{
    public function index(): View
    {
        $devices = Auth::user()->devices;
        if ($devices->isEmpty())
            $devices = null;

        $client = new Client();

        if ($devices != null) {
            foreach ($devices as $device) {
                try {
                    $response = $client->request('get', $device['method'] . "://" . $device['endpoint'] . "/rest/system/resource", [
                        'auth' => [$device['username'], $device['password']],
                        'headers' => ['Content-Type' => 'application/json'],
                        'timeout' => 0.5,
                        'verify' => false,
                        
                    ]);

                    $device['online'] = $response->getStatusCode();
                } catch (\Exception $e) {
                    $device['online'] = null;
                }
            }
        }

        return view('dashboard', ['devices' => $devices]);
    }

    public function indexDevice($deviceId): View
    {
        $device = Device::findOrFail($deviceId);
        session(['selectedDevice' => $deviceId]); // Armazena o dispositivo na sessão

        $client = new Client();

        try {
            $response = $client->request('get', $device['method'] . "://" . $device['endpoint'] . "/rest/system/resource", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 0.5,
                'verify' => false,
               
            ]);

            $data = json_decode($response->getBody(), true);

            return view('devices.index', [
                'resource' => $data,
                'device' => $device,
                'deviceParam' => $device['id'],
                'selectedDevice' => $deviceId // Passa para a view
            ]);
        } catch (\Exception $e) {
            return view('devices.index', [
                'resource' => null,
                'device' => $device,
                'conn_error' => $e->getMessage(),
                'deviceParam' => $device['id'],
                'selectedDevice' => $deviceId
            ]);
        }
    }

    public function setDeviceSession($deviceId)
    {
        session(['selectedDevice' => $deviceId]);
        return response()->json(['success' => true]);
    }

    public function create(): View
    {
        return view('devices.create');
    }

    public function store(DeviceRequest $request)
    {
        // Validate the incoming request data
        $formData = $request->validated();

        if ($formData['timeout'] == null)
            $formData['timeout'] = 3;

        // Create a new Device instance and save it to the database
        Device::create([
            'name' => $formData['name'],
            'user_id' => Auth::user()->id,
            'username' => $formData['username'],
            'password' => $formData['password'],
            'endpoint' => $formData['endpoint'],
            'method' => $formData['method'],
            'timeout' => $formData['timeout'],
        ]);

        return redirect()->route('dashboard')->with('success-msg', "A Device was added with success");
    }

    public function edit($id): View
    {
        $device = Device::findOrFail($id);
        return view('devices.edit', ['device' => $device]);
    }

    public function update(DeviceRequest $request, $id)
    {
        $formData = $request->validated();

        if ($formData['timeout'] == null)
            $formData['timeout'] = 3;

        $device = Device::findOrFail($id);
        $device->update($formData);

        return redirect()->route('dashboard')->with('success-msg', "A Device was updated with success");
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();

        return redirect()->route('dashboard')->with('success-msg', "A Device was deleted with success");
    }

    public function showSelected(Request $request)
    {
        $selectedDeviceIds = $request->input('selected_devices', []);

        // Buscar os dispositivos selecionados no banco de dados
        $selectedDevices = Device::whereIn('id', $selectedDeviceIds)->get();

        return view('devices.selected', compact('selectedDevices'));
    }
}
